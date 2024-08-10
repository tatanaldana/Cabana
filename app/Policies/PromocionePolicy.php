<?php

namespace App\Policies;

use App\Models\Promocione;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromocionePolicy
{
    use HandlesAuthorization;
    
    public function create(User $user): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para crear un nuevo proveedor.');
    }

    public function update(User $user): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para actualizar este proveedor.');
    }

    public function delete(User $user): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para eliminar este proveedor.');
    }

}
