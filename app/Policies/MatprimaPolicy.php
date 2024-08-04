<?php

namespace App\Policies;

use App\Models\Matprima;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatprimaPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasRole('admin')      
        ? $this->allow()
        : $this->deny('No tienes permiso para ver el listado de materia primas.');
    }

    public function view(User $user, Matprima $matprima): Response
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

    public function update(User $user, Matprima $matprima): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para actualizar esta materia prima.');
    }

    public function delete(User $user, Matprima $matprima): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para eliminar esta materia prima.');
    }
}
