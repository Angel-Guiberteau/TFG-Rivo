<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleMailerService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GoogleMailController extends Controller
{
    public function sendResetEmail(Request $request, GoogleMailerService $mailer)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No se encontró el usuario.']);
        }

        $token = Str::random(60);
        $url = url("/reset-password/{$token}") . '?email=' . urlencode($user->email);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        $html = view('emails.custom-reset-password', ['url' => $url])->render();

        $mailer->send($user->email, 'Restablece tu contraseña', $html);

        return back()->with('status', 'Correo de restablecimiento enviado.');
    }
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $record = DB::table('password_resets')->where('email', $data['email'])->first();

        if (!$record) {
            return back()->withErrors(['email' => 'No se encontró el token de restablecimiento para este correo.']);
        }

        // Validar token con bcrypt (como guardaste el token en bcrypt)
        if (!Hash::check($data['token'], $record->token)) {
            return back()->withErrors(['token' => 'El token de restablecimiento no es válido.']);
        }

        // Verificar caducidad 60 minutos
        $tokenCreatedAt = Carbon::parse($record->created_at);
        if (Carbon::now()->diffInMinutes($tokenCreatedAt) > 60) {
            return back()->withErrors(['token' => 'El token de restablecimiento ha expirado.']);
        }

        // Actualizar la contraseña
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No se encontró el usuario.']);
        }

        $user->password = Hash::make(value: $data['password']);
        $user->save();

        // Borrar token
        DB::table('password_resets')->where('email', $data['email'])->delete();

        return redirect()->route('login')->with('status', 'Contraseña restablecida correctamente.');
    }


}
