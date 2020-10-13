<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public static function getUserProject($id){
        $project=DB::table('progetto')->where('utente','=',$id)->get();
        return $project;
    }

    public static function getProjectbyId($id){
        $content=DB::table('progetto')->find($id);
        return view('viewProject')->with('content',$content);
    }
}
