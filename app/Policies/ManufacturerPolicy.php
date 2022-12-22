<?php

namespace App\Policies;

use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ManufacturerPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability): int
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the manufacturer.
     *
     * @param \App\Models\User         $user
     * @param \App\Models\Manufacturer $manufacturer
     *
     * @return mixed
     */
    public function view(User $user, Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Determine whether the user can create manufacturers.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the manufacturer.
     *
     * @param \App\Models\User         $user
     * @param \App\Models\Manufacturer $manufacturer
     *
     * @return mixed
     */
    public function update(User $user, Manufacturer $manufacturer)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the manufacturer.
     *
     * @param \App\Models\User         $user
     * @param \App\Models\Manufacturer $manufacturer
     *
     * @return mixed
     */
    public function delete(User $user, Manufacturer $manufacturer)
    {
        return Auth::check();
    }
}
