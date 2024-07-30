<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class CategoriaPolicy
    {
        public function create(User $user): Response
        {
            Log::info('Política de creación evaluada para usuario ID: ' . $user->id);
            return $user->hasRole('admin')
                ? Response::allow()
                : Response::deny('No tienes permiso para crear esta categoría.');
        }
    
        public function update(User $user, Categoria $categoria): Response
        {
            return $user->hasRole('admin')
                ? Response::allow()
                : Response::deny('No tienes permiso para actualizar esta categoría.');
        }
    
        public function delete(User $user, Categoria $categoria): Response
        {
            return $user->hasRole('admin')
                ? Response::allow()
                : Response::deny('No tienes permiso para eliminar esta categoría.');
        }
    }
