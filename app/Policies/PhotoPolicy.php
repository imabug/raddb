<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the photo.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Photo  $photo
     * @return mixed
     */
    public function view(User $user, Photo $photo)
    {
        //
    }

    /**
     * Determine whether the user can create photos.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the photo.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Photo  $photo
     * @return mixed
     */
    public function update(User $user, Photo $photo)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the photo.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Photo  $photo
     * @return mixed
     */
    public function delete(User $user, Photo $photo)
    {
        return Auth::check();
    }
}
