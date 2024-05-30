<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class IdeaPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Idea $idea): bool
    {
        return ($user->is_admin ||$user->id===$idea->user_id );
        //if the user is admin or the user is the creator of the idea then grant them permission
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Idea $idea): bool
    {
        return ($user->is_admin ||$user->id===$idea->user_id );
        //if the user is admin or the user is the creator of the idea then grant them permission
    }

}
