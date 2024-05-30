<?php

namespace App\Http\Controllers;
use App\Models\Idea;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Idea $idea)
    {

        $currentUser = auth()->user();
        $currentUser->likes()->attach($idea);
        // we attach the current idea to likes colum of like_ideas table
        return redirect()->route("ideas.show", $idea)->with("success", "succesfully liked idea");
    }

    public function unlike(Idea $idea){
        $currentUser = auth()->user();
        $currentUser->likes()->detach($idea);
        // we attach the current idea to likes colum of like_ideas table
        return redirect()->route("ideas.show", $idea)->with("success", "succesfully unliked idea");
    }
}
