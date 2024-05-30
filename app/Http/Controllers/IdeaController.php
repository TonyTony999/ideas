<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Policy;


class IdeaController extends Controller
{
    public function update(UpdateIdeaRequest $request, Idea $idea){

        /*
        if(auth()->id()!==$idea->user_id){
            abort(404);
        }
        */

        //Gate::authorize("idea-edit", $idea);
        //we can use our gates and pass the extra idea argument, the current user will be passed by default

        Gate::authorize("update", $idea);
        //we can also use policies to do the same

        $request->validated();

        $idea->content=request()->get("updatedContent");
        $idea->save();

       // return redirect("/")->with("success", "idea updated!");
       return redirect()->route("ideas.show", $idea)->with("success", "idea updated!");

    }

    public function edit(Idea $idea){

        /*
        if(auth()->id()!==$idea->user_id){
            abort(404); //this will redirect to a 404 page
        }
        */

        //Gate::authorize("idea-edit", $idea);
        Gate::authorize("update", $idea);

        $editing=true;
        return view("ideas.show", compact("idea","editing"));
    }

    public function show(Idea $idea){

        /*
        return view("ideas.show", [
            "idea"=>$idea
        ]);
        */

        //we can shorten the code with the compact function
        //laravel will get the idea variable that was passed and convert it into an array

        //dd($idea->comments);
        //since we linked the comments to the ideas table in the idea model
        //we are able to get the comments as a property inside the idea object

        //dd($idea->user->id);
        //dd(auth()->id());
        $editing=false;
        if(auth()->id()==$idea->user_id){
            $editing=true;
        }


        return view("ideas.show", ["idea"=>$idea, "editing"=>$editing]);


    }

    public function store(CreateIdeaRequest $request)
    {

        /*
        $idea->content=request("content");

        $idea->save();
        */

        //we can get individual form field values from the submitIdea Form request like this:
        //in case the value is empty we can pass a default value to the second argument in get

        /*
        $content = request()->get("idea", "");
        $idea = new Idea([
            "content" => $content,
            "likes" => 1
        ]);

        $idea->save();
        return redirect("/");
        */

        //we can validated that the fields of the form are filled, have a min and max length with the following:
       $validated=$request->validated();

        $validated["user_id"]=auth()->id();

        //we will append a user_id key value pair into the validated array
        //with the user_id associated with the user that creates the idea
        //using the auth() helper function
        //we can also do it like this: auth()->user()->id

        //we can also use the static property create to create records in one line

        /*
        Idea::create(
            [
                "content" => request()->get("content", "")
            ]
        );
        */

        //or we can pass the validated object aswell
        Idea::create($validated);

        return redirect("/")->with("success", "idea created!");

        //the flash session key value pair will be available in the  view associated with the redirected url
        //it will only be available after one page view, then the key value pair will be deleted

    }


    //public function destroy ($id){

        /* the most simple way */
        /*
        Idea::destroy($id);
        return redirect("/");
        */

        //or we can check if idea with id exists and then delete the first one

        //$idea= Idea::where("id", $id)->first();
        //$idea->delete();

        //in case the id is not found we can send a 404 page not found instead with firstorfail method

        //$idea= Idea::where("id", $id)->firstOrFail();
        //$idea->delete();
        //return redirect("/")->with("success", "idea deleted succesfully");

    //}

    public function destroy(Idea $idea){

        /*
        if(auth()->id()!==$idea->user_id){
            abort(404);
        }
        */

        //Gate::authorize("idea-delete", $idea);
        Gate::authorize("delete", $idea);
        $idea->delete();
        return redirect("/")->with("success", "idea deleted succesfully");

        //to shorten the code we can actually use model binding to tell laravel
        //to get an idea with the specified id of the subroute and delete it


    }
}
