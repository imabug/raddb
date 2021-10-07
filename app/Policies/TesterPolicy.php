<?php

namespace App\Policies;

use App\Models\Tester;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TesterPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the tester.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Tester $tester
     *
     * @return mixed
     */
    public function view(User $user, Tester $tester)
    {
        //
    }

    /**
     * Determine whether the user can create testers.
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
     * Determine whether the user can update the tester.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Tester $tester
     *
     * @return mixed
     */
    public function update(User $user, Tester $tester)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the tester.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\Tester $tester
     *
     * @return mixed
     */
    public function delete(User $user, Tester $tester)
    {
        return Auth::check();
    }
}
