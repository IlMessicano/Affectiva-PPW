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

/*
Route::get('/user/{id}/edit', function(){
    if(Auth::user()->id){
        $id=Auth::user()->id;
        return
    }
}
*/

