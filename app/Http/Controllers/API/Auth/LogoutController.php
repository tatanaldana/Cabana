<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
use Illuminate\Auth\AuthenticationException;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function logout(Request $request)
    {
        // Obtén el token de acceso del encabezado Authorization
        $token = $request->bearerToken();

        if (!$token) {
            // Lanzar una excepción de autenticación si el token no está presente
            throw new AuthenticationException('No token provided');
        }

        // Obtén el usuario autenticado
        $user = Auth::user();

        // Revoca todos los tokens del usuario autenticado
        $user->tokens->each(function ($token) {
            $token->revoke();
        });

        return response()->json(['message' => 'Successfully logged out']);
    }
}
