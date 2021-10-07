<?php

namespace App\Policies;

use App\Models\TestType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

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
     * @param \App\Models\User     $user
     * @param \App\Models\TestType $testType
     *
     * @return mixed
     */
    public function view(User $user, TestType $testType)
    {
        //
    }

    /**
     * Determine whether the user can create testTypes.
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
     * Determine whether the user can update the testType.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\TestType $testType
     *
     * @return mixed
     */
    public function update(User $user, TestType $testType)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the testType.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\TestType $testType
     *
     * @return mixed
     */
    public function delete(User $user, TestType $testType)
    {
        return Auth::check();
    }
}
