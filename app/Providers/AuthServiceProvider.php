<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Categoria;
use App\Models\Detpromocione;
use App\Models\Detventa;
use App\Models\Matprima;
use App\Models\Pqr;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Producto;
use App\Models\Promocione;
use App\Models\Proveedore;
use App\Models\User;
use App\Models\Venta;
use App\Policies\CategoriaPolicy;
use App\Policies\DetpromocionePolicy;
use App\Policies\DetventaPolicy;
use App\Policies\MatprimaPolicy;
use App\Policies\PqrPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\PromocionePolicy;
use App\Policies\ProveedorePolicy;
use App\Policies\UserPolicy;
use App\Policies\VentaPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Categoria::class => CategoriaPolicy::class,
        Detpromocione::class => DetpromocionePolicy::class,
        Detventa::class => DetventaPolicy::class,
        Matprima::class => MatprimaPolicy::class,
        Pqr::class => PqrPolicy::class,
        Producto::class => ProductoPolicy::class,
        Promocione::class => PromocionePolicy::class,
        Proveedore::class => ProveedorePolicy::class,
        Venta::class => VentaPolicy::class,
        User::class => UserPolicy::class,
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