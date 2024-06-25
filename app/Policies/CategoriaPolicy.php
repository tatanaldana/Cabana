<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoriaPolicy
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
            : Response::deny('No tienes permiso para crear este producto.');
    }

    public function update(User $user, Categoria $categoria): Response
    {
        return $user->hasRole('admin') 
            ? Response::allow()
            : Response::deny('No tienes permiso para actualizar este producto.');
    }

    public function delete(User $user, Categoria $categoria): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('No tienes permiso para eliminar este producto.');
    }


}
