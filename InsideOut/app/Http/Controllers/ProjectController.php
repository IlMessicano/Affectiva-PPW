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
        $content=Progetto::find($id);
        return view('viewProject')->with('content',$content);
    }

    public static function getProjectbyId($id){
        $project=Progetto::find($id);
        return $project;
    }

     public function insertProject(Request $request){
        $new_project=new Progetto;
        $new_project->nome = $request->nome;
        $new_project->descrizione = $request->descrizione;
        $new_project->utente = $request->utente;
        $new_project->dataCreazione = now();
        $new_project->save();
        $iframe=route('project',['id'=>$new_project->id]);
        return redirect('home')->with ('iframe',$iframe);
     }

    public function updateProject(Request $request){
        $project= Progetto::find($request->id);
        $project->nome = $request->nome;
        $project->descrizione = $request->descrizione;
        $project->save();
        $iframe=route('project',['id'=>$project->id]);
        return redirect('home')->with ('iframe',$iframe);
    }

    public function destroyProject(Request $request){
        Progetto::destroy($request->progetto);

        return redirect()->route('home');
    }

    public static function saveJson($id, Request $request){

        $video= Progetto::find($id);
        $video->risultatiAnalisi = $request->data;
        $video->save();
        return $video;
    }
}
