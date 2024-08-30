<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\PasswordResetRequest;
use App\Http\Requests\API\Auth\RegistroRequest;
use App\Mail\ConfirmationEmail;
use App\Mail\PasswordResetEmail;
use App\Models\User;
use App\Models\EmailConfirmation;
use App\Models\PasswordReset;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RegistroController extends Controller
{
    public function store(RegistroRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $clienteRole = Role::where('name', 'cliente')->first();
        $user->assignRole($clienteRole);

        // Generar un token de confirmación
        $token = Str::random(32);

        // Almacenar el token en la tabla email_confirmations
        EmailConfirmation::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        // Enviar correo de confirmación
        Mail::to($user->email)->send(new ConfirmationEmail($user, $token));

        return response()->json([
            'message' => 'Registro creado exitosamente. Por favor, revisa tu correo para confirmar tu cuenta.'
        ], Response::HTTP_CREATED);
    }

    public function requestPasswordReset(PasswordResetRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->firstOrFail();

        // Generar un token de restablecimiento
        $token = Str::random(32);

        // Almacenar el token en la tabla password_resets
        PasswordReset::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        // Enviar correo de restablecimiento
        Mail::to($user->email)->send(new PasswordResetEmail($user, $token));

        return response()->json(['message' => 'Enlace de restablecimiento de contraseña enviado.']);
    }
}

