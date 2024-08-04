<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class VentaPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasRole('admin')     
         ? $this->allow()
        : $this->deny('No tienes permiso para ver el listado de ventas.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model,Venta $venta): Response
    {
        return $user->hasRole('admin') || $user->id === $model->id
        ? $this->allow()
        : $this->deny('No tienes permiso para ver esta venta.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user,User $model): Response
    {
        return $user->hasRole('admin') || $user->id === $model->id
        ? $this->allow()
        : $this->deny('No tienes permiso para realizar esta venta.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model,Venta $venta): Response
    {
        return $user->hasRole('admin') || $user->id === $model->id
        ? $this->allow()
        : $this->deny('No tienes permiso para actualizar esta venta.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model,Venta $venta): Response
    {
        return $user->hasRole('admin') || $user->id === $model->id
        ? $this->allow()
        : $this->deny('No tienes permiso para eliminar esta venta.');
    }


}
