<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class InviteUserNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = url("/reset-password/{$this->token}?email={$notifiable->email}");

        return (new MailMessage)
            ->subject("Invitation à rejoindre la plateforme")
            ->line("Un compte a été créé pour vous.")
            ->action("Définir mon mot de passe", $url);
    }
}
