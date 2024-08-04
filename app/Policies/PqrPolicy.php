<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pqr;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;


class PqrPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->hasRole('admin')      
        ? $this->allow()
        : $this->deny('No tienes permiso para ver el lisatado de PQRS.');
    }

    public function view(User $user, Pqr $pqr): Response
    {
        return $user->hasRole('admin') || $user->id === $pqr->user_id
            ? $this->allow()
            : $this->deny('No tienes permiso para ver esta PQR.');
    }

    public function create(User $user): Response
    {
        return $user->hasRole('cliente')
            ? $this->allow()
            : $this->deny('No tienes permiso para crear una nueva PQR.');
    }

    public function update(User $user, Pqr $pqr): Response
    {
        return $user->hasRole('admin') 
            ? $this->allow()
            : $this->deny('No tienes permiso para actualizar esta PQR.');
    }

    public function delete(User $user, Pqr $pqr): Response
    {
        return $user->hasRole('admin') || $user->id === $pqr->user_id
            ? $this->allow()
            : $this->deny('No tienes permiso para eliminar esta PQR.');
    }
}
