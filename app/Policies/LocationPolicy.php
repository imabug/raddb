<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the location.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Location  $location
     * @return mixed
     */
    public function view(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the location.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Location  $location
     * @return mixed
     */
    public function update(User $user, Location $location)
    {
        //
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Location  $location
     * @return mixed
     */
    public function delete(User $user, Location $location)
    {
        //
    }
}
