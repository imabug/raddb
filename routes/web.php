<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/*
 * Dashboard routes
 */
// Survey schedule
Route::get('/', 'DashboardController@index');
// Equipment testing status dashboard
Route::get('/dashboard', 'DashboardController@teststatus');
Route::get('/teststatus', function() {
  return redirect('/dashboard');
});
// Count of surveys per month for year $yr
Route::get('/surveycount/{yr}', 'DashboardController@surveycount');

/*
 * Machine controller
 */
// Show index of machines grouped by modality
Route::get('machines/modalities', 'MachineController@showModalityIndex');
// List of machines for a selected modality/modalities
Route::get('machines/modalities/{id}', 'MachineController@showModality')
    ->where('id', '[0-9]+');
// Show index of machines grouped by location
Route::get('machines/locations', 'MachineController@showLocationIndex');
// List of machines for a selected location(s)
Route::get('machines/locations/{id}', 'MachineController@showLocation')
    ->where('id', '[0-9]+');
Route::resource('machines', 'MachineController');

Route::resource('contacts', 'ContactController');
Route::resource('gendata', 'GenDataController');
Route::resource('opnotes', 'OpNoteController');

/*
 * Recommendation controller
 */
Route::resource('recommendations', 'RecommendationController');
Route::resource('surveys', 'TestDateController');

// Tube controller
Route::get('tubes/{id}/create', 'TubeController@create')
    ->where('id', '[0-9]+');
Route::resource('tubes', 'TubeController');

// Routes for managing the lookup tables
Route::resource('admin/locations', 'LocationController');
Route::resource('admin/manufacturers', 'ManufacturerController');
Route::resource('admin/modalities', 'ModalityController');
Route::resource('admin/testers', 'TesterController');
Route::resource('admin/testtypes', 'TestTypeController');
