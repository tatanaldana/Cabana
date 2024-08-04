<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Token;
use Illuminate\Database\Eloquent\Model;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $validatedData = $request->validated();

        // Obtener el ID del usuario autenticado
        $userId = Auth::guard('api')->id();

        // Buscar el token en la base de datos utilizando el ID del usuario
        $tokenModel = Token::where('user_id', $userId)->first();

        if (!$tokenModel) {
            return response()->json(['error' => 'Token no encontrado.'], 401);
        }

        // Verificar si la contraseña actual proporcionada es correcta
        if (!Hash::check($validatedData['current_password'], $tokenModel->user->password)) {
            return response()->json(['error' => 'La contraseña actual es incorrecta.'], 400);
        }

        // Actualizar la contraseña
        $tokenModel->user->password = Hash::make($validatedData['new_password']);
        $tokenModel->user->save();

        // Revocar todos los tokens del usuario
        $this->revokeUserTokens($tokenModel->user);

        return response()->json(['message' => 'Contraseña cambiada exitosamente y sesión cerrada.']);
    }

    protected function revokeUserTokens($user)
    {
        // Revocar todos los tokens de acceso del usuario
        $user->tokens->each(function ($token) {
            $token->revoke();
        });
    }
}
