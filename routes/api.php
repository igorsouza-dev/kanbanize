<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['prefix'=>'/boards'], function() {
//    Route::get('/{board}', 'BoardController@getBoard');
//});
Route::get('/boards/get', 'BoardController@getBoard');
Route::get('/boards/columns', 'BoardController@columns');

Route::post('/columns/add', 'ColumnController@store');
Route::put('/columns/edit/id/{column}', 'ColumnController@update');
Route::delete('/columns/delete/id/{column}', 'ColumnController@destroy');
Route::get('/columns/move/id/{column}', 'ColumnController@moveColumn');

Route::post('/cards/add', 'CardController@store');
Route::put('/cards/edit/id/{card}', 'CardController@update');
Route::delete('/cards/delete/id/{card}', 'CardController@destroy');
Route::get('/cards/move/id/{card}', 'CardController@moveCard');

Route::get('/users/get', 'UserController@getUsers');
