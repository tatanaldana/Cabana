<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Token;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        $validatedData = $request->validated();

        // Obtener el usuario autenticado usando Passport
        $user = Auth::user();

        // Verificar si la contraseña actual proporcionada es correcta
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json(['error' => 'La contraseña actual es incorrecta.'], 400);
        }

        // Hashear la nueva contraseña y actualizar en el modelo
        $user->password = Hash::make($validatedData['new_password']);
        $user->update(
            [
                'password'=>Hash::make($validatedData['new_password'])
            ]
        );
        // Invalidar los tokens existentes del usuario
        Token::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Contraseña cambiada exitosamente.']);
    }
}
