<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\Recommendation;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecommendationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the recommendation.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Recommendation  $recommendation
     * @return mixed
     */
    public function view(User $user, Recommendation $recommendation)
    {
        //
    }

    /**
     * Determine whether the user can create recommendations.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the recommendation.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Recommendation  $recommendation
     * @return mixed
     */
    public function update(User $user, Recommendation $recommendation)
    {
        //
    }

    /**
     * Determine whether the user can delete the recommendation.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Recommendation  $recommendation
     * @return mixed
     */
    public function delete(User $user, Recommendation $recommendation)
    {
        //
    }
}
