<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controlador DashboardController
 *
 * Redirige al usuario autenticado a la vista correspondiente según su rol o estado de configuración inicial.
 */
class DashboardController extends Controller
{
    /**
     * Redirige al panel correspondiente según el tipo de usuario.
     *
     * - Admin: redirige a homeAdmin
     * - Usuario nuevo: redirige a initialSetup
     * - Usuario normal: redirige a home
     *
     * @param Request $request Instancia de la petición HTTP.
     * @return \Illuminate\Http\RedirectResponse Redirección a la vista correspondiente.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->rol_id === 1) {
            return redirect()->route('homeAdmin');
        }

        if ($user->isNewUser) {
            return redirect()->route('initialSetup');
        }

        return redirect()->route('home');
    }
}
