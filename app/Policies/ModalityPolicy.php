<?php

namespace RadDB\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use RadDB\Models\Modality;
use RadDB\Models\User;

class ModalityPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the modality.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Modality  $modality
     * @return mixed
     */
    public function view(User $user, Modality $modality)
    {
        //
    }

    /**
     * Determine whether the user can create modalities.
     *
     * @param  \RadDB\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the modality.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Modality  $modality
     * @return mixed
     */
    public function update(User $user, Modality $modality)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the modality.
     *
     * @param  \RadDB\Models\User  $user
     * @param  \RadDB\Models\Modality  $modality
     * @return mixed
     */
    public function delete(User $user, Modality $modality)
    {
        return Auth::check();
    }
}
