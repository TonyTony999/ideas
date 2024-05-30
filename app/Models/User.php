<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use App\Models\Idea;
//use App\Models\Comment;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'bio',
        'image',
        'password'
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function ideas(){
        return $this->hasMany(Idea::class)->latest();
        //this is the same as using $this->hasMany(Idea::class)->orderBy("created_at", "DESC")
    }

    public function comments(){
        return $this->hasMany(Comment::class)->latest();
    }

    public function followings(){
        return $this->belongsToMany(User::class, "follower_user", "follower_id", "user_id")->withTimestamps();
    }

    public function followers(){
        return $this->belongsToMany(User::class, "follower_user", "user_id", "follower_id")->withTimestamps();
    }

    public function follows(User $user){

        return $this->followings->contains($user);
        //we can check if the current user follows or not a certain user
        //by checking if a $user exists in the followings table , this will return a boolean
    }

    public function likes(){
        return $this->belongsToMany(Idea::class, "idea_like")->withTimestamps();
    }

    public function liked(Idea $idea){
        return $this->likes->contains($idea);
    }


    public function getImageURL(){
        if($this->image){
            return url('storage/'. $this->image);
        }
        return "https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario";
    }


}
