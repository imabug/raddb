<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use App\Models\MachinePhoto;
use App\Models\User;

class MachinePhotoPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the machinePhoto.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MachinePhoto  $machinePhoto
     * @return mixed
     */
    public function view(User $user, MachinePhoto $machinePhoto)
    {
        //
    }

    /**
     * Determine whether the user can create machinePhotos.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can store machinePhoto.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the machinePhoto.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MachinePhoto  $machinePhoto
     * @return mixed
     */
    public function update(User $user, MachinePhoto $machinePhoto)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the machinePhoto.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MachinePhoto  $machinePhoto
     * @return mixed
     */
    public function delete(User $user, MachinePhoto $machinePhoto)
    {
        return Auth::check();
    }
}
