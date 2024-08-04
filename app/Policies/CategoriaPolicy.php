<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class CategoriaPolicy
    {
        use HandlesAuthorization;
        
        public function create(User $user): Response
        {
            return $user->hasRole('admin')
                ? $this->allow()
                : $this->deny('No tienes permiso para crear esta categoría.');
        }
    
        public function update(User $user, Categoria $categoria): Response
        {
            return $user->hasRole('admin')
                ? $this->allow()
                : $this->deny('No tienes permiso para actualizar esta categoría.');
        }
    
        public function delete(User $user, Categoria $categoria): Response
        {
            return $user->hasRole('admin')
                ? $this->allow()
                : $this->deny('No tienes permiso para eliminar esta categoría.');
        }
    }
