<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
            'nomeVideo.*' => 'mimes:avi'
        ]);

        if ($request->hasfile('nomeVideo')) {

            foreach ($request->file('nomeVideo') as $key => $value) {

                if ($files = $value) {
                    $destinationPath = 'public/video/';
                    $fileName = $request->file('nomeVideo')[$key]->getClientOriginalName();
                    $files->move($destinationPath, $fileName);
                    $save[$key]['nomeVideo'] = "$fileName";
                    $save[$key]['pathVideo'] = "$destinationPath$fileName";
                }
            }

        }

        Video::insert($save);

        return Redirect::to("video-upload")
            ->withSuccess('Caricamento completato!');

    }

    public function getVideo()
    {
        $video = DB::table('video')->get();
        return view('/video-upload', compact('video'));
    }

    public function destroy(Request $request)
    {

        $checked = $request->input('checked');
        $video = DB::table('video')->select('pathVideo')->where('id', '=', $checked)->get();


        $video = str_replace('/', '', $video);
        $video = str_replace('{', '', $video);
        $video = str_replace('}', '', $video);
        $video = str_replace('(', '', $video);
        $video = str_replace(')', '', $video);
        $video = str_replace('[', '', $video);
        $video = str_replace(']', '', $video);
        $video = str_replace(':', '', $video);
        $video = str_replace('"', '', $video);
        $video = str_replace('pathVideo', '', $video);

        unlink($video);
        Video::destroy($checked);


        return Redirect::to("video-upload")
            ->withSuccess('Video eliminato!');

    }
}
