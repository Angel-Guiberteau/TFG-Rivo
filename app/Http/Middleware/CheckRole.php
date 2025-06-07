<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;

/**
 * Middleware que verifica si el usuario autenticado tiene alguno de los roles permitidos.
 *
 * @package App\Http\Middleware
 */
class CheckRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * Comprueba si el usuario está autenticado y si su rol coincide con alguno de los roles permitidos.
     * Si no está autenticado, redirige al inicio. Si no tiene el rol adecuado, lanza un error 403.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP entrante.
     * @param \Closure $next La siguiente función middleware.
     * @param mixed ...$roles Lista de roles permitidos.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user()->load('role');

        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Acceso denegado.');
        }

        return $next($request);
    }
}
