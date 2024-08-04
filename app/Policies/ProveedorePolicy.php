<?php

namespace App\Policies;

use App\Models\Proveedore;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProveedorePolicy
{

    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasRole('admin')      
        ? $this->allow()
        : $this->deny('No tienes permiso para ver el listado de proveedores.');
    }

    public function view(User $user, Proveedore $proveedore): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para ver esta materia prima.');
    }

    public function create(User $user): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para crear una nueva materia prima.');
    }

    public function update(User $user, Proveedore $proveedore): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para actualizar esta materia prima.');
    }

    public function delete(User $user, Proveedore $proveedore): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para eliminar esta materia prima.');
    }

}
