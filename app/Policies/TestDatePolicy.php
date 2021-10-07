<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use App\Models\TestDate;
use App\Models\User;

class TestDatePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the testDate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TestDate  $testDate
     * @return mixed
     */
    public function view(User $user, TestDate $testDate)
    {
        //
    }

    /**
     * Determine whether the user can create testDates.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can add survey reports.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function storeSurveyReport(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the testDate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TestDate  $testDate
     * @return mixed
     */
    public function update(User $user, TestDate $testDate)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the testDate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TestDate  $testDate
     * @return mixed
     */
    public function delete(User $user, TestDate $testDate)
    {
        //
    }
}
