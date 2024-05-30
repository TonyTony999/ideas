<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Idea;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::define("admin", function(User $user){
            return (bool) $user->is_admin;
        });

         //\Debugbar::enable();
         //this is so we can enable the debugbar

        //Cache::flush();
        //we can clear cache like this

        $topUsers=Cache::remember('topUsers', now()->addMinutes(3), function () {
            return User::withCount('ideas')->orderBy('ideas_count', 'DESC')->limit(5)->get();
        });

        //here we are setting the cache for top users sql queries , with the key topusers
        //for 3 minute from the current datetime with the value of the query
        //this means that if the topusers key is found on the cache
        //laravel will use that value , if its not found then the value will be fetched after 3 minutes

        View::share("topUsers",$topUsers);

        //View::share("topUsers",User::withCount('ideas')->orderBy('ideas_count', 'DESC')->limit(5)->get() );
        //we can share data to all views by setting the varname and then the value inside the share static method of view class

        //app()->setLocale("en");//
        //we can change the locale like this ^

        //we define the name of the gate and inside the callback function
        //we can check if the user is an admin, this will return a boolean
        //the gate can be used inside the admin dashboard controller laravel will know the user by default

        /*
        Gate::define("idea-edit", function(User $user,Idea $idea){
            $isAdmin=(bool) $user->is_admin;
            $isCreator=$idea->user_id===$user->id;
            return (bool)($isAdmin || $isCreator);

        });

        Gate::define("idea-delete", function(User $user,Idea $idea){
            $isAdmin=(bool) $user->is_admin;
            $isCreator=$idea->user_id===$user->id;
            return (bool)($isAdmin || $isCreator);

        });
        */

    }
}
