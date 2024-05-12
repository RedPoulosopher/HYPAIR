<?php
 
namespace App\Http\Controllers;
 
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\NotificationToken;

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

    static function sendPushNotificationToTokens($tokens, $title, $body, $url="/")
    {
        if(env('NOTIFICATIONS_ENABLED') == false){
            return 'Les notifications sont désactivées sur ce serveur';
        }

        $messaging = PushNotificationController::connectToFirebase();
 
        //Create message object
        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $title,
                'body' => $body
            ],
            'data' => [
                'url' => $url
            ],
        ]);
 
        //Send message to all users subscribed to the topic
        return $messaging->sendMulticast($message, $tokens);
    }

    public function testPushNotification(){
        $result = $this->sendPostNotification(Post::first());
        return response()->json($result);
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

        // Envoi de la notification
        $result = PushNotificationController::sendPushNotificationToTokens($tokens, 'Nouveau post de ' . $post->entite()->first()->nom, $post->titre, $post->url());
        
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