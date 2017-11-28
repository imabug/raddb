<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\Machine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

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
     * @param  \RadDB\User  $user
     * @param  \RadDB\Machine  $machine
     * @return mixed
     */
    public function view(User $user, Machine $machine)
    {
        //
    }

    /**
     * Determine whether the user can create machines.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can store machines.
     *
     * @param \RadDB\User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return Auth::check();
    }
    
    /**
     * Determine whether the user can update the machine.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Machine  $machine
     * @return mixed
     */
    public function update(User $user, Machine $machine)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the machine.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Machine  $machine
     * @return mixed
     */
    public function delete(User $user, Machine $machine)
    {
        //
    }
}
