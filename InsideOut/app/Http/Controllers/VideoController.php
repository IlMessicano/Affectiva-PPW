<?php

namespace App\Http\Controllers;

use App\Video;
use App\Task;
use App\Progetto;
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
            'nomeVideo.*' => 'mimes:mp4'
        ],[
            'nomeVideo.*.mimes' => 'Formato errato! È possibile caricare solo .mp4'
        ]);

        if ($request->hasfile('nomeVideo')) {

            foreach ($request->file('nomeVideo') as $key => $value) {

                if ($files = $value) {
                    $destinationPath = 'video/';
                    $name = $request->file('nomeVideo')[$key]->getClientOriginalName();
                    $code = rand(1,10000);
                    $stringcode = chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122));
                    $fileName = "$code$stringcode.mp4";
                    $files->move($destinationPath, $fileName);
                    $save[$key]['nomeVideo'] = "$name";
                    $save[$key]['pathVideo'] = "$destinationPath$fileName";
                    $save[$key]['task'] = $request->task;
                }
                $i = $key;
            }

        }

        Video::insert($save);
        $id= DB::getPdo()->lastInsertId();

        $task = Task::find($request->task);
        $task->risultatiAnalisi = null;
        $task->save();

        $project = Progetto::find($task->progetto);
        $project->risultatiAnalisi = null;
        $project->save();


        return $id;

    }

    public function updateVideo(Request $request){
        $video=Video::find($request->id);
        $video->nomeVideo = $request->nomeVideo;
        $video->save();
        $iframe=route('video',['id'=>$video->id]);
        return redirect('home')->with('iframe',$iframe);
    }

    public static function getVideo($id)
    {
        $video = DB::table('video')->where('task','=',$id)->get();
        return $video;
    }

    public static function getAnalysisVideo($id){
        $video = Video::find($id);
        return $video->risultatiAnalisi;
    }

    public static function ViewVideobyId($id){
        $content=Video::find($id);
        return view('viewVideo')->with('content',$content);
    }

    public static function deleteFile($id){
        print_r($id);

//        $video = DB::table('video')->select('pathVideo')->where('id', '=', $id)->get();
//
//        $video = str_replace('/', '', $video);
//        $video = str_replace('{', '', $video);
//        $video = str_replace('}', '', $video);
//        $video = str_replace('(', '', $video);
//        $video = str_replace(')', '', $video);
//        $video = str_replace('[', '', $video);
//        $video = str_replace(']', '', $video);
//        $video = str_replace(':', '', $video);
//        $video = str_replace('"', '', $video);
//        $video = str_replace('pathVideo', '', $video);
//
//        unlink($video);
    }

    public function destroy(Request $request)
    {

        $checked = $request->video;

       $this->deleteFile($checked);

        Video::destroy($checked);

        $task = Task::find($request->task);
        $task->risultatiAnalisi = null;
        $task->save();

        $project = Progetto::find($task->progetto);
        $project->risultatiAnalisi = null;
        $project->save();

        return redirect()->route('home');

    }

    public static function saveJson($id, Request $request){

        $video= Video::find($id);
        $video->risultatiAnalisi = $request->data;
        $video->save();
        return $video;
    }

    public function path($id){
        $video= Video::find($id);
        return asset($video->pathVideo);
    }


    public static function check($task){

        $check = DB::table('video')->where('task','=',$task)->exists();

        return $check;
    }
}
