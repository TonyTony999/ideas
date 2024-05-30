<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikesController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\IdeaController as AdminIdeaController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;

use App\Http\Middleware\SetLocale;
use App\Http\Middleware\EnsureUserIsAdmin;

//use App\Http\Middleware\EnsureUserIsAdmin;

//use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
//use Illuminate\Http\Client\Request;
//use Illuminate\Support\Facades\App;
Route::get("test", function () {
    dd(session("keys"));
});

Route::get('lang/{lang}', function (string $lang) {

    session(['locale' => $lang]);
    //we set a session key named locale, from the lang query param
    app()->setLocale($lang);
    //we then set it to to locale variable
    return redirect()->route("dashboard");

})->name('lang');

Route::group(['middleware' => SetLocale::class], function () {
    //we set the locale if the session contains the locale key value pair
    Route::get('/', [DashboardController::class, "index"])->name("home");
    Route::get('/terms', [DashboardController::class, "terms"])->name("terms");
    Route::get('/dashboard', [DashboardController::class, "search"])->name("dashboard");;
});

//Route::get('/profile', [ProfileController::class, "index"]);

Route::get('/feed', FeedController::class)->middleware([SetLocale::class,"auth"])->name("feed"); //invokable controller with only 1 method

//we can group routes and set a prefix for the route path and also prefix the name
//so every route path will have an idea/ before and every name will have a ideas. before
//we can also set default middleware for all routes by passing a middleware argument
//with the type of middleware we want to assign , if we want a specific set of routes
//to be excluded from that middleware we can chain a without middleware func
Route::group(["prefix" => "idea/", "as" => "ideas."], function () {
    Route::post('/', [IdeaController::class, "store"])->name("create"); //->withoutMiddleware("auth"); to exclude from mware
    Route::get('/{idea}', [IdeaController::class, "show"])->name("show"); //->withoutMiddleware("auth");
    //we can create a group inside a group of routes for routes that require middleware
    Route::group(["middleware" => ["auth"]], function () {
        Route::get('/{idea}/edit', [IdeaController::class, "edit"])->name("edit");
        Route::put('/{idea}', [IdeaController::class, "update"])->name("update");
        Route::post('/{idea}/comments', [CommentController::class, "store"])->name("comments.store");
        Route::delete('/idea/delete/{idea}', [IdeaController::class, "destroy"])->name("destroy");
    });
});

Route::resource("users", UserController::class)->only("show", "edit", "update")->middleware("auth");
//this will create 3 routes using the laravel route pattern for show , edit and update methods
//the route format is the same as the one of  the route group on top
Route::get("profile", [UserController::class, "profile"])->middleware("auth")->name("profile");
Route::post("users/{user}/follow", [FollowerController::class, "follow"])->middleware("auth")->name("users.follow");
Route::post("users/{user}/unfollow", [FollowerController::class, "unfollow"])->middleware("auth")->name("users.unfollow");

Route::post("ideas/{idea}/like", [LikesController::class, "like"])->middleware("auth")->name("ideas.like");
Route::post("ideas/{idea}/unlike", [LikesController::class, "unlike"])->middleware("auth")->name("ideas.unlike");

//Route::get('/admin', [AdminDashboardController::class, "index"])->name("admin.dashboard")->middleware(["auth", "can:admin"]);
//we can apply a gate name to the can middleware to ensure the user is an admin before sending him to a specific view
//"can:gate_name"

Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix('/admin')->as('admin.')->group(function(){

    Route::get('/', [AdminDashboardController::class, "index"])->name("dashboard");
    Route::get('/users', [AdminUsersController::class, "index"])->name("users");
    Route::get('/ideas', [AdminIdeaController::class, "index"])->name("ideas");
});

Route::group(["middleware" => ["guest"]], function () {
    Route::get('/register', [AuthController::class, "index"])->name("register");
    Route::post('/register', [AuthController::class, "store"])->name("auth.create");
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

//the guest middleware is the opposite of the auth middleware
//it means that the above routes will only work for unauthenticated guest users



Route::post('/logout', [AuthController::class, 'logout'])->middleware("auth")->name('logout');
