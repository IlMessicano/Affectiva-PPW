<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function findFromEmail($email)
    {
        $user = DB::table('users')->where('email', $email)->get();
        return $user;
    }

    public function showUser($id)
    {
        $user = User::find($id);

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

    public function editUser(Request $request)
    {

        $id = auth()->user()->id;
        $user = User::find($id);

        $column = $request->column;
        $data = $request->data;

        $user -> $column = $data;

        $user -> save();
       // return UserController::showUser($id);
        return view('profile')->with('user', $user);
    }

    public function editPassword(Request $request){

        $id = auth()->user()->id;
        $user=User::find($id);

        if (Hash::make($request->current_password) == $user->password && $request->new_password == $request->new_confirm_password){
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
            return redirect()->route('password.updated', ['id' => $id])->withErrors(['password_updated' => 'aggiornato']);
        }
        else {
            return redirect()->route('password.not.updated', ['id' => $id])->withErrors(['password_not_updated' => 'non aggiornato']);
        }
    }

}
