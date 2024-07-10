<?php
 
namespace App\Http\Controllers;
 
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\User;
use App\Models\NotificationToken;
use App\Models\Entite;

use DateTime;
use DateTimeZone;
 
class PushNotificationController extends Controller
{
    static function connectToFirebase(){
        //Connect to Firebase with the API Key
        $firebase = (new Factory)
        ->withServiceAccount(__DIR__.'/../../../resources/notifications/firebase_credentials.json');
    
        $messaging = $firebase->createMessaging();

        return $messaging;
    }

    static function sendPushNotificationToTopic($topic, $title, $body, $url="/")
    {
        if(env('NOTIFICATIONS_ENABLED') == false){
            return 'Les notifications sont désactivées sur ce serveur';
        }

        $messaging = PushNotificationController::connectToFirebase();
 
        //Create message object
        $message = CloudMessage::fromArray([
            'topic' => $topic,
            'notification' => [
                'title' => $title,
                'body' => $body
            ],
            'data' => [
                'url' => $url
            ],
        ]);
 
        //Send message to all users subscribed to the topic
        return $messaging->send($message);
    }

    static function sendPushNotificationToTokens($tokens, $title, $body, $icon=null, $url="/", $tag=null, $tagData=[])
    {
        if(env('NOTIFICATIONS_ENABLED') == false){
            return 'Les notifications sont désactivées sur ce serveur';
        }

        $messaging = PushNotificationController::connectToFirebase();
 
        $data = array_merge([
            'url' => $url,
            'tag' => $tag
        ], $tagData);

        if($icon){
            $data = array_merge($data, ['icon' => $icon]);
        }

        //Create message object
        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $title,
                'body' => $body
            ],
            'data' => $data
        ]);
 
        //Send message to all users subscribed to the topic
        return $messaging->sendMulticast($message, $tokens);
    }

    public function testPushNotification(Request $request){

        // In production env, send test notifications only to specific users
        if (App::environment('production')) {
            $requestBody = $request->all();
            
            // Check if correct password
            if(!isset($requestBody['password']) || $requestBody['password'] != getenv('TEST_NOTIFS_PASSWORD')){
                abort(403, "Mauvais mot de passe");
            }

            // Notification by user uid
            if(isset($requestBody['user'])){

                // We check that the user exists
                if(!User::existe($requestBody['user'])){
                    return "Cet utilisateur n'est pas dans la base de données";
                }

                $user_tokens = User::where('uid', $requestBody['user'])
                                ->first()
                                ->notificationTokens
                                ->pluck('token')
                                ->unique()
                                ->toArray();

                // We check that the user has at least one notification token
                if(count($user_tokens) == 0){
                    return "Cet utilisateur n'a pas de token enregistré";
                }

                // Send test notification only to this user
                $result = $this->sendPushNotificationToTokens(
                    $user_tokens,
                    "Notification test AIR",
                    "Ceci est une notification de test envoyée par l'AIR à " . $requestBody['user'],
                    url: "/air"
                );

                return response()->json($result);
            }

            // By default, get all notification tokens of AIR members
            $air_tokens = Entite::where('uid', 'air')
                            ->first()
                            ->membres
                            ->flatMap(function ($membre) {
                                return $membre->user->notificationTokens->pluck('token');
                            })
                            ->unique()
                            ->toArray();

                            
            // Send test notification only to AIR members
            $result = $this->sendPushNotificationToTokens(
                $air_tokens,
                "Notification test AIR",
                "Cette notification n'est reçue que par les membres de l'AIR",
                url: "/air"
            );
            return response()->json($result);
            
        // In dev and local env, send test notifications to every subscriber
        } else {
            $randomPost = Post::all()->random(1)->first();
            $result = $this->sendPostNotification($randomPost);
            return response()->json($result);
        }
    }

    public function souscrireNotifications(Request $request)
	{
        if(env('NOTIFICATIONS_ENABLED') == false){
            abort(403, "Les notifications sont désactivées sur ce serveur");
        }


        //On récupère les paramètres de la requête
        $requestBody = json_decode($request->getContent(), true);
		$topics = $requestBody['topics'];
        $fcmRegistrationToken = $requestBody['token'];

        if (Auth::check()) {
            
            $user = Auth::user();
            
            // On vérifie qu'il s'agit d'un nouveau token de notification
            $savedToken = $user->notificationTokens()->where('token', '=', $fcmRegistrationToken)->first();
            if($savedToken == null){
                //On sauvegarde le nouveau token
                $notif_token = new NotificationToken;
                $notif_token->user_id =  $user->id;
                $notif_token->token = $fcmRegistrationToken;
                $notif_token->save();

                // On se connecte à FCM
                $messaging = $this->connectToFirebase();
                
                // On souscrit l'utilisateur aux topics demandés
                $result = $messaging->subscribeToTopics($topics, $fcmRegistrationToken);
                
                return response()->json($result);
            }

            return response()->json("L'utilisateur est déjà souscrit");
    
        }
        
        abort(403, "L'utilisateur n'est pas connecté");        
    }

    static function sendPostNotification($post){
        // On récupère la liste des utilisateurs à notifier
        $users = $post->campus->flatMap->users;
        $tokens = $users->flatMap->notificationTokens->pluck('token')->unique()->toArray();

        if(empty($tokens)){
            return;
        }

        $icon_url = $post->entite()->first()->logo_url("tres-petit");
        $icon_url = Str::endsWith($icon_url, ".png") ? $icon_url : null;

        // Envoi de la notification
        $result = PushNotificationController::sendPushNotificationToTokens(
            $tokens,
            'Nouveau post de ' . $post->entite()->first()->nom,
            $post->titre,
            icon: $icon_url,
            url: $post->url(),
            tag: "POST",
            tagData: [
                'entite' => $post->entite()->first()->nom
            ]
        );
        
        // Suppression des tokens périmés / incorrects
        $unknownTokens = $result->unknownTokens();
        $invalidTokens = $result->invalidTokens();
        $tokensToDelete = array_merge($unknownTokens, $invalidTokens);
        NotificationToken::whereIn('token', $tokensToDelete)->delete();

        // Sauvegarde du fait que la notification a été envoyée
        $post->notification_sent = true;
        $post->save();

        return $result;
    }

    //Cette fonction est run par un scheduler toutes les minutes
    static function sendLatestNotifications(){        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $start_date =  date('Y-m-d H:i:s', strtotime("-2 minutes", strtotime($now)));

        //On récupère les posts des 20 dernières minutes qui n'ont pas été envoyés
        $posts = Post::where('date_apparition','>=',$start_date)
                     ->where('date_apparition','<=', $now)
                     ->where('notification_sent', false)
                     ->orderBy('date_apparition', 'asc')
                     ->get();


        //Pour chacun des posts on envoie une notification
        foreach($posts as $post){
            PushNotificationController::sendPostNotification($post);
        }

        return;
    }


}