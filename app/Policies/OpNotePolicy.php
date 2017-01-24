<?php

namespace RadDB\Policies;

use RadDB\User;
use RadDB\OpNote;
use Illuminate\Auth\Access\HandlesAuthorization;

class OpNotePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the opNote.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\OpNote  $opNote
     * @return mixed
     */
    public function view(User $user, OpNote $opNote)
    {
        //
    }

    /**
     * Determine whether the user can create opNotes.
     *
     * @param  \RadDB\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the opNote.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\OpNote  $opNote
     * @return mixed
     */
    public function update(User $user, OpNote $opNote)
    {
        //
    }

    /**
     * Determine whether the user can delete the opNote.
     *
     * @param  \RadDB\User  $user
     * @param  \RadDB\OpNote  $opNote
     * @return mixed
     */
    public function delete(User $user, OpNote $opNote)
    {
        //
    }
}
