<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('boards', 'BoardController');
Route::resource('columns', 'ColumnController');
Route::post('boards/{board}/columns', 'ColumnController@store');
Route::get('boards/{board}/kanban', 'KanbanController@show');
Route::resource('cards', 'CardController');
Route::get('/api/boards/{board}/columns', 'BoardController@columns');
Route::get('/cards/{card}/move-left', 'CardController@moveLeft');
Route::get('/cards/{card}/move-right', 'CardController@moveRight');
Route::get('/cards/{card}/move-card/{column}/{pos}', 'CardController@moveCard');
