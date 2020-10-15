<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{
    public static function getShareWithMe($id){
        $share=DB::table('condivisione')->where('collaboratore','=',$id)->get();
        return $share;
    }

    public static function getSharebyProject($id){
        $share=DB::table('condivisione')->select('collaboratore')->where('progetto','=',$id)->get();
        return $share;
    }

}
