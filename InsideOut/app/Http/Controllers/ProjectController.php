<?php

namespace App\Http\Controllers;

use App\Progetto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{
    public static function getUserProject($id){
        $project=DB::table('progetto')->where('utente','=',$id)->get();
        return $project;
    }

    public static function ViewProjectbyId($id){
        $content=DB::table('progetto')->find($id);
        return view('viewProject')->with('content',$content);
    }

    public static function getProjectbyId($id){
        $project=DB::table('progetto')->find($id);
        return $project;
    }

     public function insertProject(Request $request){
        $new_project=new Progetto;
        $new_project->nome = $request->nome;
        $new_project->descrizione = $request->descrizione;
        $new_project->utente = $request->utente;
        $new_project->dataCreazione = now();
        $new_project->save();
        return redirect('home');
     }

}
