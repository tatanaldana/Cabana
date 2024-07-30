<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\RefreshTokenRequest;
use App\Models\User;
use App\Traits\Token;

class RefreshTokenController extends Controller
{
    use Token;

    public function refreshToken(RefreshTokenRequest $request)
    {
        // Validar que el `user_id` y `refresh_token` estén presentes en la solicitud
        $validatedData = $request->validated();
        
        // Obtener el usuario desde la solicitud
        $user = User::find($validatedData['user_id']);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        try {
            // Llamar al método del trait para refrescar el token, pasando el `refresh_token`
            $newTokens = $this->resolveAuthorization($user, $validatedData['refresh_token']);

            // Devolver el nuevo token de acceso y el nuevo token de refresco en la respuesta
            return response()->json($newTokens);
        } catch (\Exception $e) {
            // Capturar y devolver el error en caso de que el refresco del token falle
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
