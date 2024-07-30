<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\MissingScopeException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'No autenticado. Por favor, inicie sesión.',
            ], 401);
        }

        if ($exception instanceof MissingScopeException) {
            return response()->json([
                'error' => 'Alcance requerido no proporcionado. ' . $exception->getMessage(),
            ], 403);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'error' => 'No autorizado. ' . $exception->getMessage(),
            ], 403);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'El recurso solicitado no se encontró.',
            ], 404);
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => 'Error de validación.',
                'messages' => $exception->errors(),
            ], 422);
        }

        return response()->json([
            'error' => 'Error interno del servidor. ' . $exception->getMessage(),
        ], 500);


        return parent::render($request, $exception);
    }
}

