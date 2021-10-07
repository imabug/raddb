<?php

namespace RadDB\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use RadDB\Models\Recommendation;
use RadDB\Models\User;

class RecommendationPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the recommendation.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Recommendation  $recommendation
     * @return mixed
     */
    public function view(User $user, Recommendation $recommendation)
    {
        //
    }

    /**
     * Determine whether the user can create recommendations.
     *
     * @param  \RadDB\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the recommendation.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Recommendation  $recommendation
     * @return mixed
     */
    public function update(User $user, Recommendation $recommendation)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the recommendation.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Recommendation  $recommendation
     * @return mixed
     */
    public function delete(User $user, Recommendation $recommendation)
    {
        //
    }
}
