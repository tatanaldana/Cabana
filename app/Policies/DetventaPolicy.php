<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Detventa;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetventaPolicy
{
    use HandlesAuthorization;
     /**
     * Determine whether the user can view any Detventas.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasRole('admin')
            ? $this->allow()
            : $this->deny('No tienes permiso para ver los detalles de venta.');
    }

    /**
     * Determine whether the user can create Detventas.
     */
    public function create(User $user,Detventa $detventa): Response
    {
        return $user->hasRole('admin') || $user->id === $detventa->user_id
            ? $this->allow()
            : $this->deny('No tienes permiso para crear detalles de venta.');
    }

     /**
     * Determine whether the user can view a single Detventa model.
     */
    private function viewSingle(User $user, Detventa $detventa): bool
    {
        // Aquí defines la lógica para permitir el acceso a una sola instancia
        return $user->hasRole('admin') ||$user->id === $detventa->user_id;
    }

    /**
     * Determine whether the user can view the collection of Detventa models.
     */
    public function view(User $user, $detventas): Response
    {
        // Aquí $detventas es una colección de modelos Detventa
        foreach ($detventas as $detventa) {
            if (!$this->viewSingle($user, $detventa)) {
                return $this->deny('No tienes permiso para ver algunos detalles de venta en esta colección.');
            }
        }

        return $this->allow();
    }
}
