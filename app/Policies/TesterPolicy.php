<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\Tester;
use Illuminate\Auth\Access\HandlesAuthorization;

class TesterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the tester.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Tester  $tester
     * @return mixed
     */
    public function view(User $user, Tester $tester)
    {
        //
    }

    /**
     * Determine whether the user can create testers.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the tester.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Tester  $tester
     * @return mixed
     */
    public function update(User $user, Tester $tester)
    {
        //
    }

    /**
     * Determine whether the user can delete the tester.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Tester  $tester
     * @return mixed
     */
    public function delete(User $user, Tester $tester)
    {
        //
    }
}
