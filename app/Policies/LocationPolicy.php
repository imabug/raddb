<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

// use Illuminate\Support\Facades\Auth;

class LocationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability): int
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the location.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Location $location
     *
     * @return mixed
     */
    public function view(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        // return Auth::check();
    }

    /**
     * Determine whether the user can update the location.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Location $location
     *
     * @return mixed
     */
    public function update(User $user, Location $location)
    {
        // return Auth::check();
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Location $location
     *
     * @return mixed
     */
    public function delete(User $user, Location $location)
    {
        // return Auth::check();
    }
}
