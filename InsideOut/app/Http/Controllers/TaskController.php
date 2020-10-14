<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
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

    public function insertTask(Request $request){
        $new_task=new Task;
        $new_task->nomeTask = $request->nome;
        $new_task->descrizione = $request->descrizione;
        $new_task->progetto = $request->progetto;
        $new_task->save();
        return redirect('home');
    }
}
