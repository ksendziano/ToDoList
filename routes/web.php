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

Route::name('boards.')->prefix('boards')->group(function() {
    Route::get('/', 'BoardController@index')->name('index');
    Route::get('/{board_id}', 'BoardController@show')->name('show');
    Route::post('/', 'BoardController@store')->name('store');
    Route::get('/download', 'BoardController@download')->name('download');
    Route::post('/{board}', 'BoardController@edit')->name('edit');
    Route::post('/{board}/edit', 'BoardController@update')->name('update');
    Route::delete('/{board}', 'BoardController@destroy')->name('destroy');

    Route::name('tasks.')->prefix('{board_id}/tasks')->group(function() {
        Route::get('/', 'TaskController@index')->name('index');
        Route::post('/task', 'TaskController@store')->name('store');
        Route::get('/{task}', 'TaskController@edit')->name('edit');
        Route::post('/{task}/edit', 'TaskController@update')->name('update');
        Route::post('/{task}/copy', 'TaskController@copy')->name('copy');
        Route::post('/{task}/move', 'TaskController@move')->name('move');
        Route::delete('/{task}/destroy', 'TaskController@destroy')->name('destroy');
    });
});
