<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'No autenticado. Por favor, inicie sesión.',
            ], Response::HTTP_UNAUTHORIZED); // 401
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'error' => 'No autorizado. No tienes permiso para realizar esta acción.',
                'messages' => $exception->getMessage(),
            ], Response::HTTP_FORBIDDEN); // 403
        }

        if ($exception instanceof MissingScopeException) {
            return response()->json([
                'error' => 'Alcance requerido no proporcionado. Verifica tus permisos.',
            ], Response::HTTP_FORBIDDEN); // 403
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'El recurso solicitado no se encontró.',
            ], Response::HTTP_NOT_FOUND); // 404
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => 'Error de validación.',
                'messages' => $exception->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
        }

        if ($exception instanceof \InvalidArgumentException) {
            return response()->json([
                'error' => 'Solicitud incorrecta. Verifica los datos enviados.',
            ], Response::HTTP_BAD_REQUEST); // 400
        }

        // Manejo de otras excepciones generales
        if ($exception instanceof \Exception) {
            return response()->json([
                'error' => 'Error interno del servidor.',
                'details' => env('APP_DEBUG') ? $exception->getMessage() : 'Error interno del servidor.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // 500
        }

        // Llamada al manejador de excepciones base para cualquier excepción no manejada específicamente
        return parent::render($request, $exception);
    }
}
