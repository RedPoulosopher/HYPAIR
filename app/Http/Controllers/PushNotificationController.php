<?php
 
namespace App\Http\Controllers;
 
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class PushNotificationController extends Controller
{
    public function connectToFirebase(){
        //Connect to Firebase with the API Key
        $firebase = (new Factory)
        ->withServiceAccount(__DIR__.'/../../../config/firebase_credentials.json');
    
        $messaging = $firebase->createMessaging();

        return $messaging;
    }
    public function sendPushNotification($topic, $title, $body, $url="/")
    {
        if(env('NOTIFICATIONS_ENABLED') == false){
            return 'Les notifications sont désactivées sur ce serveur';
        }

        $messaging = $this->connectToFirebase();
 
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
            
            // On sauvegarde le token de notification
            $user = Auth::user();
            $user->notification_token = $fcmRegistrationToken;
            $user->save();
        
            // On se connecte à FCM
            $messaging = $this->connectToFirebase();
            
            // On souscrit l'utilisateur aux topics demandés
            $result = $messaging->subscribeToTopics($topics, $fcmRegistrationToken);
    
            return response()->json($result);
        }
        
        abort(403, "L'utilisateur n'est pas connecté");        
    }


}