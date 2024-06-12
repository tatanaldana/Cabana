<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    public function store(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->firstOrFail();

        if (Hash::check($request->password, $user->password)) {
             // Generar el token de acceso con el scope adecuado
             $token = $user->getAccessToken($user, $request->password);
            // Cargar los roles del usuario
            $user->load('roles');

            // Obtener el nombre del rol asociado al usuario (si existe)
            $roleName = $user->roles->isNotEmpty() ? $user->roles->first()->name : null;

            // Devolver la respuesta con los datos del usuario y el nombre del rol
            return response()->json([
                'user' => new UserResource($user),
                'token' =>new TokenResource($token),
                'role' => $roleName,  
            ]);
        } else {
            return response()->json(['message' => 'These credentials do not match our records'], 401);
        }
    }
}