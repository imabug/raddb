<?php

namespace App\Policies;

use App\Models\OpNote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class OpNotePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability): int
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the opNote.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\OpNote $opNote
     *
     * @return mixed
     */
    public function view(User $user, OpNote $opNote)
    {
        //
    }

    /**
     * Determine whether the user can create opNotes.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        // return Auth::check();
    }

    /**
     * Determine whether the user can store opNotes.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function store(User $user)
    {
        // return Auth::check();
    }

    /**
     * Determine whether the user can update the opNote.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\OpNote $opNote
     *
     * @return mixed
     */
    public function update(User $user, OpNote $opNote)
    {
        // return Auth::check();
    }

    /**
     * Determine whether the user can delete the opNote.
     *
     * @param \App\Models\User   $user
     * @param \App\Models\OpNote $opNote
     *
     * @return mixed
     */
    public function delete(User $user, OpNote $opNote)
    {
        // return Auth::check();
    }
}
