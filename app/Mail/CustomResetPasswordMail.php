<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->email,
        ], false));

        return $this->subject('Restablece tu contraseña - RIVO')
                    ->view('emails.custom-reset-password')
                    ->with([
                        'token' => $this->token,
                        'email' => $this->email,
                        'url' => $url,
                    ]);
    }


}

