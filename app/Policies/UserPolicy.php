<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->is_admin){
            return true;
        }

        return $user->is($model);
        //this is the same as $user->id===$model->id
        //we check that the user to be uptaded is the same user that is logged in

    }


}
