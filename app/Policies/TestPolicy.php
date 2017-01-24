<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\Test;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the test.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Test  $test
     * @return mixed
     */
    public function view(User $user, Test $test)
    {
        //
    }

    /**
     * Determine whether the user can create tests.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the test.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Test  $test
     * @return mixed
     */
    public function update(User $user, Test $test)
    {
        //
    }

    /**
     * Determine whether the user can delete the test.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Test  $test
     * @return mixed
     */
    public function delete(User $user, Test $test)
    {
        //
    }
}
