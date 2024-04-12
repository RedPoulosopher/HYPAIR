<?php
 
namespace App\Http\Controllers;
 
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

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
    static function sendPushNotification($topic, $title, $body, $url="/")
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

    public function testPushNotification(){
        $result = $this->sendPushNotification('posts', 'Notifcation test', 'Ceci est une notification de test');
        
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
            if($user->notification_token != $fcmRegistrationToken){
                //On sauvegarde le nouveau token
                $user->notification_token = $fcmRegistrationToken;
                $user->save();

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
        // Envoi de la notification
        $result = PushNotificationController::sendPushNotification('posts', 'Nouveau post de ' . $post->entite()->first()->nom, $post->titre, $post->url());

        // Sauvegarde du fait que la notification a été envoyée
        $post->notification_sent = true;
        $post->save();
    }

    //Cette fonction est run par un scheduler toutes les 15 minutes
    static function sendLatestNotifications(){        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $start_date =  date('Y-m-d H:i:s', strtotime("-20 minutes", strtotime($now)));

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