<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUserDetails($id){
        $user = DB::table('users')->where('id',$id)->get();
        return view('profile',compact('user'));
    }

    public static function getEmailbyId($id){
        $email= DB::table('users')->select('email')->find($id);
        return $email;
    }
}
