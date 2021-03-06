<?php

namespace RadDB\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use RadDB\Manufacturer;
use RadDB\User;

class ManufacturerPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the manufacturer.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Manufacturer  $manufacturer
     * @return mixed
     */
    public function view(User $user, Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Determine whether the user can create manufacturers.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the manufacturer.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Manufacturer  $manufacturer
     * @return mixed
     */
    public function update(User $user, Manufacturer $manufacturer)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the manufacturer.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Manufacturer  $manufacturer
     * @return mixed
     */
    public function delete(User $user, Manufacturer $manufacturer)
    {
        return Auth::check();
    }
}
