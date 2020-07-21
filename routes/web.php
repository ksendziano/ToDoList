<?php

use Illuminate\Support\Facades\Route;
use App\User;
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
Route::auth();
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('home');
});
Route::get('/moderator', 'UserController@index');

Route::get('/user{id}/boards', 'BoardController@showBoards');
Route::get('/user{id}/board/{board_id}', 'BoardController@index');
Route::post('/user{id}/board', 'BoardController@store');
Route::delete('/user{id}/board/{board}', 'BoardController@destroy');

Route::post('/user{id}/task', 'TaskController@store');
Route::get('/user{id}/task/{task}','TaskController@openEdit');
Route::post('/user{id}/task/{task}/edit', 'TaskController@edit');
Route::post('/user{id}/task/{task}/copy', 'TaskController@copy');
Route::post('/user{id}/task/{task}/replace', 'TaskController@replace');
Route::delete('/user{id}/task/{task}', 'TaskController@destroy');
