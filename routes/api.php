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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('machines/{id}/recommendations', 'MachineController@getRecommendations')
    ->where('id', '[0-9]+');
Route::get('machines/{id}/opnotes', 'MachineController@getOperationalNotes')
    ->where('id', '[0-9]+');
Route::get('machines/{id}/gendata', 'MachineController@getGenData')
    ->where('id', '[0-9]+');
Route::get('machines/{id}/tubes', 'MachineController@getTubes')
    ->where('id', '[0-9]+');
