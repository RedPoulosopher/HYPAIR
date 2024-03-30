<?php
 
namespace App\Http\Controllers;
 
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
 
class PushNotificationController extends Controller
{
    public function sendPushNotification($topic, $title, $body)
    {
        //Connect to Firebase with the API Key
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/../../../config/firebase_credentials.json');
 
        $messaging = $firebase->createMessaging();
 
        //Create message object
        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $title,
                'body' => $body
            ],
            'topic' => $topic
        ]);
 
        //Send message
        $messaging->send($message);
    }

    public function testPushNotification(){
        $this->sendPushNotification('global', 'Hello from Firebase!', 'This is a test notification.');
        
        return "Push notification sent successfully";
    }
}