<?php

namespace RadDB\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use RadDB\Models\Tester;
use RadDB\Models\User;

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
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Tester  $tester
     * @return mixed
     */
    public function view(User $user, Tester $tester)
    {
        //
    }

    /**
     * Determine whether the user can create testers.
     *
     * @param  \RadDB\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the tester.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Tester  $tester
     * @return mixed
     */
    public function update(User $user, Tester $tester)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the tester.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Tester  $tester
     * @return mixed
     */
    public function delete(User $user, Tester $tester)
    {
        return Auth::check();
    }
}
