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
Route::auth();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('home');
});

Route::get('/boards', 'BoardController@index');
Route::post('/board', 'BoardController@store');
Route::delete('/board/{board}', 'BoardController@destroy');

Route::get('/tasks', 'TaskController@index');
Route::post('/task', 'TaskController@store');
Route::get('/task/{task}','TaskController@openEdit');
Route::post('/task/{task}/edit', 'TaskController@edit');
Route::post('/task/{task}/copy', 'TaskController@copy');
Route::post('/task/{task}/replace', 'TaskController@replace');
Route::delete('/task/{task}', 'TaskController@destroy');
