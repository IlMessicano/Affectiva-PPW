<?php

namespace App\Http\Controllers;

class UserController extends Controller
{

    public function getUserDetails($id){
        $users = \DB::table('users')->get();
        return view('profile')->with('user', $users);
    }
}
