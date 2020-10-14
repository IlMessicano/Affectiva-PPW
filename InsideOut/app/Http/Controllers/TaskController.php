<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public static function getTasksOfProject($id){
        $task=DB::table('task')->where('progetto','=',$id)->get();
        return $task;
    }

    public static function ViewTaskbyId($id){
        $content=DB::table('task')->find($id);
        return view('viewTask')->with('content',$content);
    }

    public static function getTaskbyId($id){
        $content=DB::table('task')->find($id);
        return $content;
    }

}
