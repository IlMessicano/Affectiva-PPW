<?php

namespace App\Http\Controllers;

use App\Share;
use App\User;
use App\Progetto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{
    public static function getShareWithMe($id){
        $share=DB::table('condivisione')->where('collaboratore','=',$id)->get();
        return $share;
    }

    public static function getSharebyProject($id){
        $share= Share::where('progetto','=',$id)->get();
        return $share;
    }

    public static function checkEmail($email){
        $find = false;
        $user = User::all();
        foreach ($user as $share){
            if($share->email == $email){
                $find = true;
            }
        }
        return $find;
    }

    public static function insertShare(Request $request){
        $find=self::checkEmail($request->share_email);
        if($find == false){
            return back()->withErrors(['share' => 'Spiacente, la mail inserita non è valida!']);
        }
        else{
            $share= new Share;
            $share->proprietario= $request->proprietario;
            $share->progetto= $request->progetto;
            $shareId= User::where('email',$request->share_email)->first();
            $share->collaboratore= $shareId->id;
            $share->created_at = now();
            $share->save();
//            $iframe=route('project',['id'=>$new_project->id]);
            return back();
        }
    }

    public function destroyShare(Request $request){

        Share::destroy($request->id_share);
        return back();
    }
}
