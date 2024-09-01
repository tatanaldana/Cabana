<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Token as PassportToken;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\RefreshToken as PassportRefreshToken;


trait Token
{
    public function getAccessToken(User $user, $password)
    {
        $baseUrl = Config::get('app.url');
        $endpoint = '/oauth/token';
        $url = $baseUrl . $endpoint;
        $scopes = $user->hasRole('admin') ? 'admin' : 'cliente';


        $response =  Http::asForm()->post($url, [
            'grant_type' => 'password',
            'client_id' => config('services.cabaña.client_id'),
            'client_secret' => config('services.cabaña.client_secret'),
            'username' => $user->email,
            'password' => $password,
            'scope' => $scopes,
        ]);

        if ($response->successful()) {
            $token = $response->object();
            $token->scopes = $scopes;
            return $token; // Devuelve el token de acceso exitosamente
        } else {
            // Captura el cuerpo de la respuesta para obtener detalles del error
            $errorBody = $response->body();
            throw new \Exception("La solicitud para obtener el token de acceso falló: " . $response->status() . " - " . $errorBody);
        }
    }

    public function getAccessTokenMovil(User $user, $password)
    {
        $baseUrl = Config::get('app.url');
        $endpoint = '/oauth/token';
        $url = $baseUrl . $endpoint;
        $scopes = $user->hasRole('admin') ? 'admin' : 'cliente';


        $response =  Http::asForm()->post($url, [
            'grant_type' => 'password',
            'client_id' => config('services.Arcamovil.client_id'),
            'client_secret' => config('services.Arcamovil.client_secret'),
            'username' => $user->email,
            'password' => $password,
            'scope' => $scopes,
        ]);

        if ($response->successful()) {
            $token = $response->object();
            $token->scopes = $scopes;
            return $token; // Devuelve el token de acceso exitosamente
        } else {
            // Captura el cuerpo de la respuesta para obtener detalles del error
            $errorBody = $response->body();
            throw new \Exception("La solicitud para obtener el token de acceso falló: " . $response->status() . " - " . $errorBody);
        }
    }

    protected function resolveAuthorization(User $user, string $refreshToken): array
    {
        $baseUrl = Config::get('app.url');
        $endpoint = '/oauth/token';
        $url = $baseUrl . $endpoint;
    
        // Buscar el token de acceso para el usuario en la tabla oauth_access_tokens
        $accessToken = $user->tokens->first(); // Obtener el primer token asociado al usuario
    
        if ($accessToken) {
            // Revocar el token de acceso actual
            Http::post($baseUrl . '/oauth/revoke', [
                'token' => $accessToken->id,
                'client_id' => config('services.cabaña.client_id'),
                'client_secret' => config('services.cabaña.client_secret'),
            ]);
    
            // Revocar el token de refresco actual
            Http::post($baseUrl . '/oauth/revoke', [
                'token' => $refreshToken,
                'client_id' => config('services.cabaña.client_id'),
                'client_secret' => config('services.cabaña.client_secret'),
                'token_type_hint' => 'refresh_token',
            ]);
    
            // Solicitar nuevos tokens
            $response = Http::asForm([
                'Accept' => 'application/json'
            ])->post($url, [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
                'client_id' => config('services.cabaña.client_id'),
                'client_secret' => config('services.cabaña.client_secret'),
                'scope' => $user->hasRole('admin') ? 'admin' : 'cliente'
            ]);
    
            if ($response->successful()) {
                return $response->json();
            } else {
                $errorBody = $response->body();
                throw new \Exception("La solicitud para refrescar el token de acceso falló: " . $response->status() . " - " . $errorBody);
            }
        } else {
            throw new \Exception("Token de acceso no encontrado.");
        }
    }

    public function revokeOldTokens(User $user)
    {
        // Revocar todos los tokens de acceso del usuario
        $user->tokens->each(function ($token) {
            $token->revoke();
        });
    }
}
