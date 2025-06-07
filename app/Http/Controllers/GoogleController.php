<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

/**
 * Controlador GoogleController
 *
 * Gestiona la autenticación mediante Google OAuth usando Laravel Socialite.
 */
class GoogleController extends Controller
{
    /**
     * Redirige al usuario a la página de autenticación de Google.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja la respuesta de Google tras la autenticación.
     *
     * Si el usuario no existe en la base de datos, lo crea con los datos de Google.
     * Luego lo autentica en el sistema y lo redirige al panel correspondiente.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Busca un usuario por email
            $user = User::where('email', $googleUser->getEmail())->first();

            // Si no existe, lo crea
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(30)),
                    'rol_id' => 2, // usuario por defecto
                ]);

                $user = $user->fresh();
            }

            // Autentica al usuario
            Auth::login($user, remember: true);
            $user->load('role');

            // Redirige según el rol
            return match ($user->role->name) {
                'admin' => redirect()->route('dashboard'),
                'user' => redirect()->route('dashboard'),
                default => redirect('/'),
            };

        } catch (\Exception $e) {
            return redirect('/');
        }
    }
}
