<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Token as PassportToken;

trait Token{


    public function getAccessToken(User $user, $password){

        $url = 'http://arcaweb.test/oauth/token';
    
        $scopes = $user->hasRole('admin') ? 'admin' : 'cliente';
    

        $response = Http::asForm()->post($url, [
            'grant_type' => 'password',
            'client_id' => config('services.cabaña.client_id'),
            'client_secret' => config('services.cabaña.client_secret'),
            'username' => $user->email,
            'password' => $password,
            'scopes' => $scopes,
        ]);

        if ($response->successful()) {
            // Obtén el token de acceso como objeto JSON
            $token = $response->object();
            $token->scopes = $scopes;
            // Devuelve el token de acceso
            return $token; 
        } else {
            throw new \Exception("La solicitud para obtener el token de acceso falló: " . $response->status());
        }
    }

    public function resolveAuthorization(User $user) {
        $accessToken = $user->tokens()->where('name', 'access_token')->first();
    
        if ($accessToken && $accessToken->expires_at->isPast()) {
            $scopes = $user->hasRole('admin') ? 'admin' : 'cliente';
    
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post('http://arcaweb.test/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $accessToken->refresh_token,
                'client_id' => config('services.cabaña.client_id'),
                'client_secret' => config('services.cabaña.client_secret'),
                'scope' => $scopes
            ]);
    
            if ($response->successful()) {
                $access_token = $response->json();
                return $access_token;

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
                // Tu lógica de actualización de tokens aquí
            } else {
                throw new \Exception("La solicitud para obtener el token de acceso falló: " . $response->status());
            }
        }
    }
    
    
}
