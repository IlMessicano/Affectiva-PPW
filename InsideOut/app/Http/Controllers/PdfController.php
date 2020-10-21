<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public static function createPDF($table,$id) {
        // retreive all records from db
        $data = DB::table($table)->where('id', $id)->first();
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf_view_'.$table);

        // download PDF file with download method
        if($table=='video'){
            $name= $data->nomeVideo;
        }
        elseif($table=='progetto'){
            $name= $data->nome;
        }
        elseif($table=='task'){
            $name= $data->nomeTask;
        }
        return $pdf->download($name.'.pdf');
    }
}
