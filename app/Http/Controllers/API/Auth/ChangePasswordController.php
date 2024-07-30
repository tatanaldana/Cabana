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

        // Obtener el usuario autenticado usando Passport
        $user = Auth::user();

        // Verificar que $user es una instancia de User
        if (!($user instanceof Model)) {
            return response()->json(['error' => 'El usuario no es una instancia de Eloquent Model.'], 500);
        }

        // Verificar si la contraseña actual proporcionada es correcta
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json(['error' => 'La contraseña actual es incorrecta.'], 400);
        }

        // Hashear la nueva contraseña y actualizar en el modelo
        $user->password = Hash::make($validatedData['new_password']);
        $user->save(); // Guarda los cambios en la base de datos

        // Invalidar todos los tokens del usuario
        Token::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Contraseña cambiada exitosamente y sesión cerrada.']);
    }
}
