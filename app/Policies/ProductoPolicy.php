<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('No tienes permiso para crear esta categoría.');
    }

    public function update(User $user, Producto $producto): Response
    {
        return $user->hasRole('admin') 
            ? Response::allow()
            : Response::deny('No tienes permiso para actualizar esta categoría.');
    }

    public function delete(User $user, Producto $producto): Response
    {
        return $user->hasRole('admin') 
            ? Response::allow()
            : Response::deny('No tienes permiso para eliminar esta categoría.');
    }

}