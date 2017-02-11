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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('machines/{id}/recommendations', 'MachineController@getRecommendations')->name('api.machines.recommendations');
Route::get('machines/{id}/opnotes', 'MachineController@getOperationalNotes')->name('api.machines.opnotes');
Route::get('machines/{id}/gendata', 'MachineController@getGenData')->name('api.machines.gendata');
Route::get('machines/{id}/tubes', 'MachineController@getTubes')->name('api.machines.tubes');
