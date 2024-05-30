<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    protected $with=["user:id,name,image", "comments.user:id,name,image"];

    //we can set a $with property to reduce the number of duplicate queries to be executed
    //by default we enable eager loading for those models, however this means that by default
    //for every idea sql query , we will load the users and comment.user , if we want to
    //disable this behaviour we can pass a without("model_name") method to the query like this
    // $ideas=Idea::without("user")->orderBy("created_at", "DESC")->paginate(5);

    //we can also only query specific columns , we do this by appending a :column_name to the model

    protected $withCount=["likes"];
    //this is similar to with , in this case we use withCount to remove
    //duplicate sql queries for likes count of every idea


    protected $fillable = [
        "user_id",
        "content"
    ];


    /*
    protected $guarded=[
        "id",
        "created_at"
    ];
    */

    //we can also set the guarded prop , that tells laravel to enable
    //mass asigning records with properties that are gotten with request()->all()
    //except the ones that we specify in the array


    public function comments(){
        /* here we are defining a relationship of one to many between the idea
        table and the comments table , laravel will automatically search for the
        foreign keys that link both tables  */
        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
        /*Here we are setting a relationship of one to one between
        an idea and a user, an idea will always belong to a user */
    }

    public function likes(){
        return $this->belongsToMany(User::class, "idea_like");
    }

    public function scopeSearch(Builder $query , $search){
        $query->where("content", "like", "%" . $search ."%" );
    }

    //to reutilize queries we can add them to a public function inside
    //the model , we always need to prefix the function name with scope
}
