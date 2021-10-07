<?php

namespace App\Policies;

use App\Models\Modality;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

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
     * @param \App\Models\User     $user
     * @param \App\Models\Modality $modality
     *
     * @return mixed
     */
    public function view(User $user, Modality $modality)
    {
        //
    }

    /**
     * Determine whether the user can create modalities.
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
     * Determine whether the user can update the modality.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Modality $modality
     *
     * @return mixed
     */
    public function update(User $user, Modality $modality)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the modality.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Modality $modality
     *
     * @return mixed
     */
    public function delete(User $user, Modality $modality)
    {
        return Auth::check();
    }
}
