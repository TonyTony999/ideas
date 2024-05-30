<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index(){

        /*
        if(!Gate::allows("admin")){
            abort(403);
        }
        */

        //with the gate that we defined in the appserviceprovider.php file
        //we can check if the current user is an admin , if he is not ,
        //we can throw a forbiden 403 server error

        /*
        if(Gate::denies("admin")){
            abort(403);
        }
        */
        //we can also use gate:denies which do the opposite of gate : allows



        return view("admin.dashboard");

    }
}
