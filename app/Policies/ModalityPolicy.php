<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\Modality;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModalityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the modality.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Modality  $modality
     * @return mixed
     */
    public function view(User $user, Modality $modality)
    {
        //
    }

    /**
     * Determine whether the user can create modalities.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the modality.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Modality  $modality
     * @return mixed
     */
    public function update(User $user, Modality $modality)
    {
        //
    }

    /**
     * Determine whether the user can delete the modality.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\Modality  $modality
     * @return mixed
     */
    public function delete(User $user, Modality $modality)
    {
        //
    }
}
