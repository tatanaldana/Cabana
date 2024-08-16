<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Image;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can view the image.
     */
    public function view(User $user, Image $image)
    {
        return $user->hasRole('admin') || $user->id === $image->imageable_id;
    }

    /**
     * Determine if the given user can create an image.
     */
    public function create(User $user, $model)
    {
        return $user->hasRole('admin') || $user->id === $model->id;
    }

    /**
     * Determine if the given user can update the image.
     */
    public function update(User $user, Image $image)
    {
        return $user->hasRole('admin') || $user->id === $image->imageable_id;
    }

    /**
     * Determine if the given user can delete the image.
     */
    public function delete(User $user, Image $image)
    {
        return $user->hasRole('admin') || $user->id === $image->imageable_id;
    }
}


