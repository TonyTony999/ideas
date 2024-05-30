<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Idea;
class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //$ideas=Idea::orderBy("created_at", "DESC");


        $currentUser=auth()->user();

        $followingIds=$currentUser->followings()->pluck("user_id");
        //we get the associated followings table from the current user and
        //we only get the column user_id with the pluck method


        //instead of ordrerBy desc, we can use latest()

        $ideas= Idea::whereIn("user_id",$followingIds )->latest();
        //here we are searching all the ideas that belong to each
        //user_id entry that is being followed from the followingids table

        //dd($ideas);


        //where content like %search_query_param_val% in SQL

        //we can verify if there is a query param named search in the request
        if(request()->has("search")){
            $ideas=$ideas->search(request('search', ''));
            //request->get("search") will get the value of the search query param
            //and will compare it to all content column values of the table ideas
            //if a value matches it will return it
            //we can query the available ideas with the where method

        }
       // $ideas=$ideas->where("content", "like", "%" . request()->get("search", "")."%" );
        //dump($ideas);

        return view('dashboard', ["ideas"=>$ideas->paginate(5), "editing"=>false]);
    }
}
