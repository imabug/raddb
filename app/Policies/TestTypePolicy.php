<?php

namespace RadDB\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use RadDB\TestType;
use RadDB\User;

class TestTypePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the testType.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\TestType  $testType
     * @return mixed
     */
    public function view(User $user, TestType $testType)
    {
        //
    }

    /**
     * Determine whether the user can create testTypes.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the testType.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\TestType  $testType
     * @return mixed
     */
    public function update(User $user, TestType $testType)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the testType.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\TestType  $testType
     * @return mixed
     */
    public function delete(User $user, TestType $testType)
    {
        return Auth::check();
    }
}
