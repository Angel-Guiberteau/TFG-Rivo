<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'email:test';

    protected $description = 'Enviar un email de prueba para verificar la configuración';

    public function handle()
    {
        Mail::raw('DEJA DE SER PUTERO', function ($message) {
            $message->to('enanillo00@gmail.com')
                    ->subject('Email de prueba Laravel');
        });

        $this->info('Email enviado correctamente.');
    }
}
