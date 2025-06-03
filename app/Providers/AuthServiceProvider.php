<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\CustomResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
       
        $this->registerPolicies();

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return new CustomResetPassword($token);
        });
    }
}
