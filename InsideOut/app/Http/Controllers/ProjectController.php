<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public static function getUserProject($id){
        $project=DB::table('progetto')->where('utente','=',$id)->get();
        return $project;
    }
}
