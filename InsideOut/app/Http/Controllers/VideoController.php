<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class VideoController extends Controller
{
    public function index()
    {
        return view('video-upload');
    }

    public function VideoStore(Request $request)
    {
        request()->validate([
            'nomeVideo' => 'required',
            'nomeVideo.*' => 'mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg'
        ]);

        if($request->hasfile('nomeVideo'))
        {

            foreach ($request->file('nomeVideo') as $key => $value)
            {

                if ($files = $value)
                {
                    $destinationPath = 'public/video/';
                    $fileName = $request->file('nomeVideo')[$key]->getClientOriginalName();
                    $files->move($destinationPath, $fileName);
                    $save[]['nomeVideo'] = "$fileName";
                }
            }

        }

        Video::insert($save);

        return Redirect::to("video-upload")
            ->withSuccess('Caricamento completato!');

    }

    public function getVideo(){
        $video = DB::table('video')->get();
        return view('/video-upload',compact('video'));
    }
}
