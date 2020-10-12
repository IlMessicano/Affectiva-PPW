<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function findLogger()
    {
        $id = Auth()->user('id');
        return $id;
    }

    public function find($id)
    {
        $user = DB::table('users')->where('id', $id)->get();
        return $user;
    }

    public function findFromEmail($email)
    {
        $user = DB::table('users')->where('email', $email)->get();
        return $user;
    }

    public function showUser($id)
    {
        $user = UserController::find($id);

        if (Auth::user()->id == $id) {
            return view('profile')->with('user', $user);
        } else {
            if ($user == '[]')
                return view('home');
            else return view('profile')->with('user', $user);
        }
    }

    public function destroy(){
        $id = Auth::user()->id;
        $user = DB::table('users')->where('id', $id)->delete();
        return $user;
    }

    public function editUser()
    {
        $id = auth()->user()->id;
        $column = $_POST['column'];
        $data = $_POST['data'];
        DB::table('users')->where('id', $id)->update([$column => $data]);
        $user = DB::table('users')->where('id', $id)->get();
       // return UserController::showUser($id);
        return view('profile')->with('user', $user);
    }
}
