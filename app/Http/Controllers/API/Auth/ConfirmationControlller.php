<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailConfirmation;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class ConfirmationControlller extends Controller
{
    public function confirmEmail($token)
    {
        // Buscar el token en la tabla email_confirmations
        $confirmation = EmailConfirmation::where('token', $token)->first();

        if (!$confirmation) {
            return response()->json(['message' => 'Token de confirmación inválido.'], Response::HTTP_BAD_REQUEST);
        }

        // Buscar al usuario asociado con el token
        $user = User::find($confirmation->user_id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'],Response::HTTP_NOT_FOUND);
        }

        // Actualizar el campo email_verified_at
        $user->email_verified_at = now();
        $user->save();

        // Eliminar el token de confirmación
        $confirmation->delete();

        return response()->json(['message' => 'Correo electrónico confirmado exitosamente.'], Response::HTTP_OK);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password'=>'required|string|min:8|max:50|regex:/[0-9]/|regex:/[a-zA-Z]/|confirmed',
        ]);

        $passwordReset = PasswordReset::where('token', $request->token)->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Token de restablecimiento inválido.'],Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($passwordReset->user_id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], Response::HTTP_NOT_FOUND);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar el token de restablecimiento
        $passwordReset->delete();

        return response()->json(['message' => 'Contraseña restablecida exitosamente.'], Response::HTTP_OK);
    }

}
