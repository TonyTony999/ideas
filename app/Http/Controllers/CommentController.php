<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CreateCommentRequest $request, Idea $idea){

        //dump(request()->all());
        //this will return all post request fields in this case content and csrf token

        $validated=$request->validated();

        $validated['idea_id']=$idea->id;
        $validated['user_id']=auth()->id();
        //$comment->content=request()->get("content");

        Comment::create($validated);

        return redirect()->route("ideas.show", $idea->id)->with("success", "commented succesfully");

    }

}
