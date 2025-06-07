<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleMailerService
{
    protected $scriptUrl;

    public function __construct()
    {
        $this->scriptUrl = env('GOOGLE_SCRIPT_URL'); // Lo leemos desde el .env
    }

    public function send($email, $subject, $message)
    {
        $response = Http::post($this->scriptUrl, [
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);

        if ($response->successful()) {
            return true;
        }

        Log::error('Error al enviar correo: ' . $response->body());
        return false;
    }
}
