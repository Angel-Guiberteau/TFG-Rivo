<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public static function listUsers()
    {
        $users = User::getAllUsers();
    
        return view('admin.users.users')
            ->with('users', $users);
    }

    public static function storeUser()
    {
        $request = request();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:100', 'unique:users,last_name'],
            'birth_date' => ['nullable', 'date'],
            'rol_id' => ['required', 'exists:roles,id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['nullable', 'string', 'max:75', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.unique' => 'El correo electrónico ya está registrado.',
            'username.unique' => 'El nombre de usuario ya existe.',
            'last_name.unique' => 'Este apellido ya pertenece a otro usuario.',
            'rol_id.exists' => 'El rol seleccionado no es válido.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        if ($validator->fails()) {
            $mensajes = implode(' ', $validator->errors()->all());

            return redirect()->back()
                ->with('error', $mensajes)
                ->withInput();
        }

        $created = User::storeUser($validator->validated());

        if (!$created) {
            return redirect()->back()
                ->with('error', 'Hubo un error al crear el usuario.')
                ->withInput();
        }

        return redirect()->route('users')->with('success', 'Usuario creado correctamente.');
    }

    public static function deleteUser(): JsonResponse
    {
        $request = request();

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'El usuario no existe.']);
        }

        $deleted = User::deleteUser($validator->validated()['id']);

        if (!$deleted) {
            return response()->json(['error' => 'Ha ocurrido un error al eliminar el usuario.']);
        }

        return response()->json(['success' => 'Usuario borrado correctamente.']);
    }

}
