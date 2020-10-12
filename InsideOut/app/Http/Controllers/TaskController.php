<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public static function getTasksOfProject($id){
        $task=DB::table('task')->where('progetto','=',$id)->get();
        return $task;
    }
}
