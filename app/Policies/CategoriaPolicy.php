<?php

namespace App\Policies;

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
    public function create(User $user)
    {
        return $user->hasRole('admin') ? Response::allow()
        : Response::deny('No tienes permiso para ver esta categoría.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        // Verificar si el usuario tiene el scope "admin" o el rol "admin"
        if ($user->tokenCan('admin') || $user->hasRole('admin')) {
            return Response::allow();
        }
        // Si la política falla, devuelve una respuesta denegada con un mensaje personalizado
        return Response::deny('No tienes permiso para realizar esta acción.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        if ($user->tokenCan('admin') || $user->hasRole('admin')) {
            return Response::allow();
        }

        return Response::deny('No tienes permiso para realizar esta accion.');
    }


}
