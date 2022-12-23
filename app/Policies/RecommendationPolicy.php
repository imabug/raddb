<?php

namespace App\Policies;

use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class RecommendationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability): int
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the recommendation.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\Recommendation $recommendation
     *
     * @return mixed
     */
    public function view(User $user, Recommendation $recommendation)
    {
        //
    }

    /**
     * Determine whether the user can create recommendations.
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
     * Determine whether the user can update the recommendation.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\Recommendation $recommendation
     *
     * @return mixed
     */
    public function update(User $user, Recommendation $recommendation)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the recommendation.
     *
     * @param \App\Models\User           $user
     * @param \App\Models\Recommendation $recommendation
     *
     * @return mixed
     */
    public function delete(User $user, Recommendation $recommendation)
    {
        //
    }
}
