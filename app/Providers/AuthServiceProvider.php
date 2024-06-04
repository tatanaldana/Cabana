<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Traits\Apitrait;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Passport::tokensExpireIn(now()->addSecond(60));
        Passport::enablePasswordGrant();
        Passport::tokensCan([
         'create-categoria'=>'Crear nueva categoria',
         'delete-categoria'=>'Eliminar categoria',
         'update-categoria'=>'Editar categoria',
         'read-categoria'=>'Mirar categorias',
        ]);

       Passport::setDefaultScope([
            'read-categoria'=>'Mirar categorias',
        ]);
    }
}
