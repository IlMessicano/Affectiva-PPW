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

Route::get('/user/{id}', [ 'as' => 'userDetail', 'uses' => 'UserController@getUserDetails']);

Route::get('/project/{id}','ProjectController@ViewProjectbyId')->name('project');

Route::get('/task/{id}','TaskController@ViewTaskbyId')->name('task');

