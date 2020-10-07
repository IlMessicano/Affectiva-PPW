<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function getUserDetails($id){
        $users = DB::table('users')->find($id);
        return view('profile')->with('user', $users);
        }
    }
