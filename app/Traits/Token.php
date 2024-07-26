<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Token as PassportToken;
use Illuminate\Support\Facades\Config;

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

    public function resolveAuthorization(User $user)
    {

        $baseUrl = Config::get('app.url');
        $endpoint = '/oauth/token';
        $url = $baseUrl . $endpoint;

        $accessToken = $user->tokens()->where('name', 'access_token')->first();

        if ($accessToken && $accessToken->expires_at->isPast()) {
            $scopes = $user->hasRole('admin') ? 'admin' : 'cliente';

            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post($url, [
                'grant_type' => 'refresh_token',
                'refresh_token' => $accessToken->refresh_token,
                'client_id' => config('services.cabaña.client_id'),
                'client_secret' => config('services.cabaña.client_secret'),
                'scope' => $scopes
            ]);

            if ($response->successful()) {
                $access_token = $response->json();
                
                PassportToken::find($accessToken->id)->update([
                    'id' => $access_token['access_token'],
                    'scopes' => $scopes,
                    'expires_at' => now()->addSeconds($access_token['expires_in'])
                ]);

                PassportToken::where('id', $accessToken->id)->update([
                    'id' => $access_token['refresh_token'],
                    'expires_at' => now()->addSeconds($access_token['expires_in'])
                ]);

                return $access_token;
            } else {
                $errorBody = $response->body();
                throw new \Exception("La solicitud para refrescar el token de acceso falló: " . $response->status() . " - " . $errorBody);
            }
        }
    }
}
