<?php

namespace App\Policies;

use App\Models\Tube;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TubePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability): int
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the tube.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Tube $tube
     *
     * @return mixed
     */
    public function view(User $user, Tube $tube)
    {
        //
    }

    /**
     * Determine whether the user can create tubes.
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
     * Determine whether the user can update the tube.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Tube $tube
     *
     * @return mixed
     */
    public function update(User $user, Tube $tube)
    {
        // return Auth::check();
    }

    /**
     * Determine whether the user can delete the tube.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Tube $tube
     *
     * @return mixed
     */
    public function delete(User $user, Tube $tube)
    {
        // return Auth::check();
    }
}
