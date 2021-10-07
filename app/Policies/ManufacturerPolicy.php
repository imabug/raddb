<?php

namespace RadDB\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use RadDB\Models\Manufacturer;
use RadDB\Models\User;

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
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Manufacturer  $manufacturer
     * @return mixed
     */
    public function view(User $user, Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Determine whether the user can create manufacturers.
     *
     * @param  \RadDB\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the manufacturer.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Manufacturer  $manufacturer
     * @return mixed
     */
    public function update(User $user, Manufacturer $manufacturer)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the manufacturer.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Manufacturer  $manufacturer
     * @return mixed
     */
    public function delete(User $user, Manufacturer $manufacturer)
    {
        return Auth::check();
    }
}
