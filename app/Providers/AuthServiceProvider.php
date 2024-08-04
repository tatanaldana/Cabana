<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Categoria;
use App\Models\Detventa;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Producto;
use App\Models\User;
use App\Policies\CategoriaPolicy;
use App\Policies\DetventaPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Categoria::class => CategoriaPolicy::class,
        User::class => UserPolicy::class,
        Producto::class => ProductoPolicy::class,
        Detventa::class => DetventaPolicy::class,
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