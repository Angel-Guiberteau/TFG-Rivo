<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Mail\CustomResetPasswordMail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Notifications\ResetPassword;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $key = Str::lower($request->input(Fortify::username())).'|'.$request->ip();
            return Limit::perMinute(5)->by($key);
        });

        RateLimiter::for('two-factor', fn(Request $request) =>
            Limit::perMinute(5)->by($request->session()->get('login.id'))
        );

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        // Validación personalizada del email antes de enviar el enlace de restablecimiento
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        // Si necesitas lógica personalizada, puedes hacerlo en el controlador o sobrescribiendo el broker de Passwords.

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::loginView(fn() => view('auth.login_register'));
        Fortify::registerView(fn() => view('auth.login_register'));

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new CustomResetPasswordMail($token, $notifiable->getEmailForPasswordReset()))
                ->to($notifiable->getEmailForPasswordReset());
        });
    }
}
