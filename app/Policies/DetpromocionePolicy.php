<?php
namespace App\Policies;

use App\Models\Detpromocione;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DetpromocionePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create Detpromociones.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para crear detalles de venta.');
    }

    /**
     * Determine whether the user can update the Detpromocione.
     */
    public function update(User $user): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para actualizar detalles de venta.');
    }
}