<?php

namespace App\Http\Controllers;
use App\Models\User;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function follow(User $user){

        //$follower=Auth::user();
        $currentUser = auth()->user();
       //$followerr=Auth::user();
        //we get the current authenticated user
        $currentUser->followings()->attach($user);
        // we attach the current user to the followings of the followed user pivot table
        return redirect()->route("users.show", $user)->with("success", "succesfully followed");

    }

    public function unfollow(User $user){

        $currentUser = auth()->user();
       //$followerr=Auth::user();
        //we get the current authenticated user
        $currentUser->followings()->detach($user);
        // we de-attach the current user from the followings of the followed user
        return redirect()->route("users.show",$user)->with("success", "succesfully unfollowed");

    }
}
