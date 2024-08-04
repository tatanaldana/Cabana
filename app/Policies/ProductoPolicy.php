<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductoPolicy
{
    use HandlesAuthorization;
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
            ? $this->allow()
            : $this->deny('No tienes permiso para crear este producto.');
    }

    public function update(User $user): Response
    {
        return $user->hasRole('admin') 
            ? $this->allow()
            : $this->deny('No tienes permiso para actualizar este producto.');
    }

    public function delete(User $user): Response
    {
        return $user->hasRole('admin') 
            ? $this->allow()
            : $this->deny('No tienes permiso para eliminar este producto.');
    }

}