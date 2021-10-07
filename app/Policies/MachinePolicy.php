<?php

namespace RadDB\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use RadDB\Models\Machine;
use RadDB\Models\User;

class MachinePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the machine.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Machine  $machine
     * @return mixed
     */
    public function view(User $user, Machine $machine)
    {
        //
    }

    /**
     * Determine whether the user can create machines.
     *
     * @param  \RadDB\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can store machines.
     *
     * @param \RadDB\Models\User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the machine.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Machine  $machine
     * @return mixed
     */
    public function update(User $user, Machine $machine)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the machine.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Machine  $machine
     * @return mixed
     */
    public function delete(User $user, Machine $machine)
    {
        //
    }
}
