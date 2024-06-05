<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AssignAccessTokenScopes
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Obtinere usum authenticate
        $user = Auth::user();

        // Obtinere scopes basate in role usus
        $scopes = [];

        if ($user) {
            // Logica pro assignare scopes basate in role usus
            if ($user->hasRole('admin')) {
                $scopes[] = 'admin';
            } elseif ($user->hasRole('cliente')) {
                $scopes[] = 'cliente';
            }
        }

        // Assignare scopes ad token accessus in responsa
        $response->headers->set('scopes', implode(' ', $scopes));

        return $response;
    }
}