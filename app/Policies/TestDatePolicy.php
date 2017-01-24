<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\TestDate;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestDatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the testDate.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\TestDate  $testDate
     * @return mixed
     */
    public function view(User $user, TestDate $testDate)
    {
        //
    }

    /**
     * Determine whether the user can create testDates.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the testDate.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\TestDate  $testDate
     * @return mixed
     */
    public function update(User $user, TestDate $testDate)
    {
        //
    }

    /**
     * Determine whether the user can delete the testDate.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\TestDate  $testDate
     * @return mixed
     */
    public function delete(User $user, TestDate $testDate)
    {
        //
    }
}
