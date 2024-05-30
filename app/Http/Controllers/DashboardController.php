<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function terms(){

        return view("terms");
    }

    public function index(){

        //$idea= new Idea(["content"=> "test2","likes"=> 3]);
        //$idea->save(); //save individual records

        /*
        $idea->content="test";
        $idea->likes=1;
        $idea->save();
        */

        /*instead of asigning values this way we can pass the values directly to the
        idea object by creating a fillable array property inside idea model */

        //$ideas=Idea::all();
        //we can get select * from ideas table by calling static all() method to get all records

        //we can sort records by desc or ascending order like this
        //$ideas=Idea::orderBy("created_at", "DESC")->get()->paginate(5);

        $ideas=Idea::orderBy("created_at", "DESC")->paginate(5);
        //this will create a likes_count variable for each idea that stores
        //the amount of likes for an idea

        //we can eager load the likes to avoid executing an individual
        //select * from comments for each idea
        //by passing the likes user relationship to withCount([])
        //this will return an inner join with the likes count of the 5 ideas

        //to enable eager loading to reduce number of sql queries we can
        //remove duplicate queries by adding the model names as arguments
        //we can eager load all users from each comment of every idea by
        //passing the model name associated with the comments after a .

        //we can also add pagination with paginate(#of items per page)

        //dump($ideas);
        //we can use the native laravel vardump function to echo values into a view
        ;

        //return new WelcomeEmail(auth()->user());
        //we can get a preview of the email that was sent to the user by getting an instance
        //of the maillable welcomeEmail class and passing in the authenticated user

        //$topUsers= User::withCount('ideas')->orderBy('ideas_count', 'DESC')->limit(5)->get();
        //withcount(ideas) will get the ideas count of all users in an optimized manner
        //with one single sql query, what we put inside withcount has to match
        //the method name that we set in the user model
        //the ideas_count property is automatically generated by withcount method , and we
        //will return the top 5 users with most ideas
        //since we already passed the topusers to the appserviceprovider we no longer need it here

        return view('dashboard', ["ideas"=>$ideas, "editing"=>false]);


    }

    public function search(){

        $ideas=Idea::orderBy("created_at", "DESC");

        //where content like %search_query_param_val% in SQL

        //we can verify if there is a query param named search in the request
        if(request()->has("search")){
            //$ideas=$ideas->where("content", "like", "%" . request()->get("search", "")."%" );
            //request->get("search") will get the value of the search query param
            //and will compare it to all content column values of the table ideas
            //if a value matches it will return it
            //we can query the available ideas with the where method

            $ideas=$ideas->search(request('search', ''));
            //here we are using the scopeSearch() method that is defined in the idea model
            //we can pass the query string from the get request to get the search value

        }
       // $ideas=$ideas->where("content", "like", "%" . request()->get("search", "")."%" );
        //dump($ideas);

        $topUsers= User::withCount('ideas')->orderBy('ideas_count', 'DESC')->limit(5)->get();

        return view('dashboard', ["ideas"=>$ideas->paginate(5), "editing"=>false,"topUsers"=> $topUsers]);

    }


}
