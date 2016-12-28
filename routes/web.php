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
Route::get('/teststatus',  'DashboardController@teststatus');

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
Route::get('recommendations/{id?}/create', 'RecommendationController@create')
    ->where('id', '[0-9]+'); // id parameter is optional
Route::resource('recommendations', 'RecommendationController');

// Test Date controller
Route::get('surveys/{machineId?}/create', 'TestDateController@create')
    ->where('machineId', '[0-9]+'); // machineId parameter is optional
Route::get('surveys/addReport', 'TestDateController@addSurveyReport');
Route::put('surveys/storeReport', 'TestDateController@storeSurveyReport');
Route::resource('surveys', 'TestDateController');

// Tube controller
Route::get('tubes/{machineID}/create', 'TubeController@create')
    ->where('machineID', '[0-9]+');
Route::resource('tubes', 'TubeController');

// Routes for managing the lookup tables
Route::resource('admin/locations', 'LocationController');
Route::resource('admin/manufacturers', 'ManufacturerController');
Route::resource('admin/modalities', 'ModalityController');
Route::resource('admin/testers', 'TesterController');
Route::resource('admin/testtypes', 'TestTypeController');

// Route for user management
Route::resource('users', 'UserController');

// Route for experiments and tests
Route::resource('test', 'TestController');

Auth::routes();

Route::get('/home', 'HomeController@index');
