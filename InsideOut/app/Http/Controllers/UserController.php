<?php

namespace App\Http\Controllers;

use App\Video;
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
        return route('home');
    }

    public function editUser(Request $request)
    {

        $id = Auth()->user()->id;
        $user = User::find($id);

        $column = $request->column;
        $data = $request->data;

        $user -> $column = $data;

        $user -> save();
       // return UserController::showUser($id);
        return view('profile')->with('user', $user);
    }

    public function editPassword(Request $request){

        $id = Auth()->user()->id;
        $user=User::find($id);

        if (Hash::check($request->current_password, $user->password)) {
            if($request->new_password == $request->new_confirm_password){
                User::find(Auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
                return redirect()->route('password.updated', ['id' => $id])->withErrors(['password_updated' => 'aggiornato']);
            }
            else{
                return redirect()->route('password.not.updated', ['id' => $id])->withErrors(['password_not_updated' => 'conferma password errata']);
            }
        }
        else {
            return redirect()->route('password.not.updated', ['id' => $id])->withErrors(['password_not_updated' => 'vecchia password errata']);
        }
    }

    public static function getEmailbyId($id){
        $email= DB::table('users')->select('email')->find($id);
        return $email;
    }

}
