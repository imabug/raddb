<?php

namespace RadDB\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use RadDB\Models\Tube;
use RadDB\Models\User;

class TubePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the tube.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Tube  $tube
     * @return mixed
     */
    public function view(User $user, Tube $tube)
    {
        //
    }

    /**
     * Determine whether the user can create tubes.
     *
     * @param  \RadDB\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the tube.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Tube  $tube
     * @return mixed
     */
    public function update(User $user, Tube $tube)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the tube.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Tube  $tube
     * @return mixed
     */
    public function delete(User $user, Tube $tube)
    {
        return Auth::check();
    }
}
