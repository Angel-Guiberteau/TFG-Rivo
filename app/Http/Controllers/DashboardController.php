<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->rol_id === 1) {
            return redirect()->route('homeAdmin');
        }
        if($user->isNewUser)
        {
            return redirect()->route('initialSetup');
        }

        return redirect()->route('home');
    }
}
