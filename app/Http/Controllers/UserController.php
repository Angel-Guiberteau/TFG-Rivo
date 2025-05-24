<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class UserController extends Controller
{

    public static function listUsers()
    {
        $users = User::getAllUsers();
    
        return view('admin.users.users')
            ->with('users', $users);
    }

    public static function storeUser(): RedirectResponse
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

    public static function getUserbyId($id)
    {
        $id = request('id');

        $validator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Usuario no existe.')
                ->withInput();
        }

        $user = User::getUserById($id);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Usuario no encontrado.')
                ->withInput();
        }

        // dd($user);

        return view('admin.users.editUser')
            ->with('user', $user);
    }

    public static function updateUser(): RedirectResponse
    {
        $request = request();
       
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'rol_id' => ['required', 'exists:roles,id'],
            'email' => ['required', 'email', 'max:255'],
            'username' => ['nullable', 'string', 'max:75'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('users')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $data = $validator->validated();
        $user = User::getUserById($data['id']);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        $updates = [];

        foreach (['name', 'last_name', 'birth_date', 'rol_id', 'email', 'username'] as $field) {
            if ($user->$field != $data[$field]) {
                $updates[$field] = $data[$field];
            }
        }

        if (!empty($data['password']) && !Hash::check($data['password'], $user->password)) {
            $updates['password'] = bcrypt($data['password']);
        }

        if (!empty($updates)) {
            $user->update($updates);
            return redirect()->route('users')->with('success', 'Usuario actualizado correctamente.');
        }

        return redirect()->route('users')->with('success', 'No se realizaron cambios.');
    }

    public function getUser(): ?Authenticatable
    {
        return User::getUser();
    }

}
