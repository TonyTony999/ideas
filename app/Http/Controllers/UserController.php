<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //if we do $user->ideas without parenthesis we will get
        //al ideas of the user, to get the actual relationship
        //we have to use parenthesis

        $ideas=$user->ideas()->paginate(5);

        return view("users.show", ["user"=>$user,"ideas"=>$ideas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        /*
        if(auth()->id()!==$user->id){
            abort(404);
        }*/

        //we can use a policy instead of the if statement above

        Gate::authorize("update",$user);

        $ideas=$user->ideas()->paginate(5);
        /*make sure to chain paginate method so the pagination button component works */
        return view("users.edit", ["user"=>$user ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        /*
        if(auth()->id()!==$user->id){
            abort(404);
        }*/

        Gate::authorize("update",$user);
        //we can use the UserPolicy that is bound to the user model
        //we check that the $user is the same authed user to determine if we grant access
        //to update the user instance

        $validated=$request->validated();

        if(request()->has("image")){
            $imagePath=$request->file('image')->store('profile','public');
            //this will check if request has an image , if it does it will store
            //the image in the profile folder inside the public disk which is publically accessible
            // now we will updated the image key in validated with the full image path

            $validated['image']=$imagePath;
            //we can delete the previous image like this:
            Storage::disk('public')->delete($user->image ?? '');
        }

        $user->update($validated);

        /*

        $user->name=request()->get("name");
        $user->bio=request()->get("bio");
        $user->save();
        */

       // return redirect("/")->with("success", "idea updated!");
       return redirect()->route("profile")->with("success", "bio updated!");

    }

    public function profile(){

        //return authenticated users profile page
        return $this->show(auth()->user());


    }

}
