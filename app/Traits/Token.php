<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Http;


trait Token{


    public function getAccessToken($email, $password){

        $url=env('APP_URL').'/oauth/token';

        $user = User::where('email', $email)->firstOrFail();

        $scope = $user->hasRole('admin') ? 'admin' : 'cliente';


        $response = Http::withHeaders([
            'Accept'=>'application\json'

            ])->post($url,
            [
                'grant_type'=>'password',
                'client_id'=>config('services.cabaña.client_id'),
                'client_secret'=>config('services.cabaña.client_secret'),
                'username'=> $email,
                'password'=> $password,
                'scope' => $scope,

        ]);

      if ($response->successful()) {

            $access_token = $response->json();

            return $access_token; 
    
        } else {
            
            throw new \Exception("La solicitud para obtener el token de acceso falló: " . $response->status());
        }
    }
}
