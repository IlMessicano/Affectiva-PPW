<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index')->name('home');

Route::get('/logout','Auth\LoginController@logout')->name('logout');

Route::get('/live', function () {
    return view('/live/live');
})->name('live');

Route::get('/user/{id}', 'UserController@showUser')->name('profile');
Route::get('/user', function() {
    if(Auth::user()->id){
        $id=Auth::user()->id;
    return redirect()->route('profile', ['id' => $id]);}
else return view('/home');});

Route::post('/user/updated', 'UserController@editUser')->name('editUser');

Route::get('/delete', 'UserController@destroy')->name('deleteUser');

Route::get('/user/{id}/change-password/updated', 'UserController@showUser')->name('password.updated');
Route::get('/user/{id}/change-password/failed', 'UserController@showUser')->name('password.not.updated');
Route::post('/user/verify-password', 'UserController@editPassword')->name('verify.password');

Route::get('/user/{id}', [ 'as' => 'userDetail', 'uses' => 'UserController@getUserDetails']);

Route::get('/project/{id}','ProjectController@ViewProjectbyId')->name('project');

Route::get('/task/{id}','TaskController@ViewTaskbyId')->name('task');

Route::get('/video/{id}',function($id){
    return view('video')->with('id', $id);
})->name('video');

Route::get('/viewVideo/{id}','VideoController@ViewVideobyId')->name('viewVideo');

Route::post('/createproject','ProjectController@insertProject')->name('insert_project');

Route::post('/createshare','ShareController@insertShare')->name('insert_share');

Route::post('/createtask','TaskController@insertTask')->name('insert_task');

Route::post('/updateproject','ProjectController@updateProject')->name('modify_project');

Route::post('/updatetask','TaskController@updateTask')->name('modify_task');

Route::post('/destroyproject','ProjectController@destroyProject')->name('delete_project');

Route::post('/destroytask','TaskController@destroyTask')->name('delete_task');

Route::post('/destroyshare','ShareController@destroyShare')->name('delete_share');

Route::get('video-upload', 'VideoController@index');
Route::post('save-video-upload', 'VideoController@VideoStore');
Route::get('video-upload', 'VideoController@getVideo');

Route::post('destroyvideo', ['uses' => 'VideoController@destroy'])->name('delete_video');
