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
        
        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'El email no ha sido verificado.'], 403);
        }

        if (Hash::check($request->password, $user->password)) {
            
            $user->revokeOldTokens($user);
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
            return response()->json(['message' => 'Sus credenciales no coinciden con las registradas'], 401);
        }
    }

    public function storeMovil(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->firstOrFail();

        if (is_null($user->email_verified_at)) {
            return response()->json(['message' => 'El email no ha sido verificado.'], 403);
        }

        if (Hash::check($request->password, $user->password)) {
            
            $user->revokeOldTokens($user);
             // Generar el token de acceso con el scope adecuado
            $token = $user->getAccessTokenMovil($user, $request->password);
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
            return response()->json(['message' => 'Sus credenciales no coinciden con las registradas'], 401);
        }
    }
}