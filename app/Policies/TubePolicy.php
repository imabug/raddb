<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\Tube;
use Illuminate\Auth\Access\HandlesAuthorization;

class TubePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the tube.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Tube  $tube
     * @return mixed
     */
    public function view(User $user, Tube $tube)
    {
        //
    }

    /**
     * Determine whether the user can create tubes.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the tube.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Tube  $tube
     * @return mixed
     */
    public function update(User $user, Tube $tube)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the tube.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Tube  $tube
     * @return mixed
     */
    public function delete(User $user, Tube $tube)
    {
        //
    }
}
