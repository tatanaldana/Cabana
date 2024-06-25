<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
        
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): Response
    {
        return $user->hasRole('admin') || $user->id === $model->id
        ? Response::allow()
        : Response::deny('No tienes permiso para ver a este usuario.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('admin')
        ? Response::allow()
        : Response::deny('No tienes permiso para crear este usuario.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        return $user->hasRole('admin') || $user->id === $model->id
        ? Response::allow()
        : Response::deny('No tienes permiso para realizar esta accion de actualizacion.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        return $user->hasRole('admin') || $user->id === $model->id
        ? Response::allow()
        : Response::deny('No tienes permiso para realizar esta accion de eliminacion.');
    }

}
