<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Image;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any images.
     */
    public function viewAny(User $user, string $modelType): bool
    {
        // Permitir la visualización sin restricciones para modelos distintos de 'users'.
        return $modelType !== 'users' || $user->hasRole('admin');
    }

    /**
     * Determine if the user can view the image.
     */
    public function view(User $user, Image $image): bool
    {
        $modelType = $image->imageable_type;

        // Verificar si el usuario puede ver la imagen de su propio perfil o si es un administrador.
        return $modelType === 'App\Models\User'
            ? ($user->id === $image->imageable_id || $user->hasRole('admin'))
            : true;
    }

    /**
     * Determine if the user can create images.
     */
    public function create(User $user, string $modelType): bool
    {
        // Permitir a los usuarios crear imágenes solo si el modelo es 'App\Models\User'
        return $modelType === 'App\Models\User' || $user->hasRole('admin');
    }

    /**
     * Determine if the user can update the image.
     */
    public function update(User $user, Image $image): bool
    {
        $modelType = $image->imageable_type;

        // Permitir la actualización de imágenes solo si el usuario es el propietario de la imagen o un administrador.
        return $modelType === 'App\Models\User'
            ? ($user->id === $image->imageable_id || $user->hasRole('admin'))
            : $user->hasRole('admin');
    }

    /**
     * Determine if the user can delete the image.
     */
    public function delete(User $user, Image $image): bool
    {
        $modelType = $image->imageable_type;

        // Permitir la eliminación de imágenes solo si el usuario es el propietario de la imagen o un administrador.
        return $modelType === 'App\Models\User'
            ? ($user->id === $image->imageable_id || $user->hasRole('admin'))
            : $user->hasRole('admin');
    }
}
