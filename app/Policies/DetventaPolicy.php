<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Detventa;
use Illuminate\Auth\Access\Response;

class DetventaPolicy
{
     /**
     * Determine whether the user can view any Detventas.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('view general')
            ? Response::allow()
            : Response::deny('No tienes permiso para ver los detalles de venta.');
    }

    /**
     * Determine whether the user can create Detventas.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create general')
            ? Response::allow()
            : Response::deny('No tienes permiso para crear detalles de venta.');
    }

     /**
     * Determine whether the user can view a single Detventa model.
     */
    private function viewSingle(User $user, Detventa $detventa): bool
    {
        // Aquí defines la lógica para permitir el acceso a una sola instancia
        return $user->hasRole('admin') || $user->hasPermission('ver personal cliente');
    }

    /**
     * Determine whether the user can view the collection of Detventa models.
     */
    public function view(User $user, $detventas): Response
    {
        // Aquí $detventas es una colección de modelos Detventa
        foreach ($detventas as $detventa) {
            if (!$this->viewSingle($user, $detventa)) {
                return Response::deny('No tienes permiso para ver algunos detalles de venta en esta colección.');
            }
        }

        return Response::allow();
    }
}
