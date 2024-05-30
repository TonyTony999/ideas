<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store()
    {
        $validated = request()->validate(
            [
                'name' => 'required|min:3|max:40',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8'
            ]
        );


        $user= User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );

        //we send an email after registrating and we pass
        //the new user to the welcome email class
        Mail::to($user->email)->send(new WelcomeEmail($user));

        return redirect()->route('dashboard')->with('success', 'Account created Successfully!');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate()
    {
        $validated = request()->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8'
            ]
        );

        //the auth() laravel helper will help us validate that the user
        //credentials are correct by comparing it to the
        //validated array

        if (auth()->attempt($validated)) {
            //if a session was already created by the user, we can
            //regenerate it when the user logs in again

            request()->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
        }

        return redirect()->route('login')->withErrors([
            'email' => "No matching user found with the provided email and password"
        ]);
    }

    public function logout(){
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'logged out successfully');
    }
}
