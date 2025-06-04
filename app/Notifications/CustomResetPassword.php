<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends Notification
{
    public $token;
    public $email;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toMail($notifiable)
    {
        $this->email = $notifiable->getEmailForPasswordReset();

        return (new MailMessage)
            ->subject('Recupera el acceso a tu cuenta en RIVO')
            ->view('emails.custom-reset-password', [
                'token' => $this->token,
                'email' => $this->email,
            ]);
    }
}
