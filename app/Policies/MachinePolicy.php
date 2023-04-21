<?php

namespace App\Policies;

use App\Models\Machine;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MachinePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability): int
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the machine.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Machine $machine
     *
     * @return mixed
     */
    public function view(User $user, Machine $machine)
    {
        //
    }

    /**
     * Determine whether the user can create machines.
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
     * Determine whether the user can store machines.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function store(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the machine.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Machine $machine
     *
     * @return mixed
     */
    public function update(User $user, Machine $machine)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the machine.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\Machine $machine
     *
     * @return mixed
     */
    public function delete(User $user, Machine $machine)
    {
        //
    }
}
