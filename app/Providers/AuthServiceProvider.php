<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Categoria' => 'App\Policies\CategoriaPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Producto' => 'App\Policies\ProductoPolicy',
        
        
    ];
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Passport::tokensExpireIn(now()->addMinutes(60));
        Passport::enablePasswordGrant();
        Passport::tokensCan([
            'admin' => 'Access all resources',
            'cliente' => 'Access limited resources',
        ]);
/*
        Passport::setDefaultScope([
            'admin',
            'cliente',
        ]);
*/
    }
}