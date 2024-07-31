<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pqr;
use Illuminate\Auth\Access\Response;

class PqrPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Pqr $pqr): Response
    {
        return $user->hasRole('admin') || $user->id === $pqr->user_id
            ? Response::allow()
            : Response::deny('No tienes permiso para ver esta PQR.');
    }

    public function create(User $user): Response
    {
        return $user->hasRole('cliente')
            ? Response::allow()
            : Response::deny('No tienes permiso para crear una nueva PQR.');
    }

    public function update(User $user, Pqr $pqr): Response
    {
        return $user->hasRole('admin') 
            ? Response::allow()
            : Response::deny('No tienes permiso para actualizar esta PQR.');
    }

    public function delete(User $user, Pqr $pqr): Response
    {
        return $user->hasRole('admin') || $user->id === $pqr->user_id
            ? Response::allow()
            : Response::deny('No tienes permiso para eliminar esta PQR.');
    }
}
