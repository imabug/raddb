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
Route::resource('machines', 'MachineController');

Route::resource('contacts', 'ContactController');
Route::resource('gendata', 'GenDataController');
Route::resource('opnotes', 'OpNoteController');

/*
 * Recommendation controller
 */
Route::get('recommendations/{id?}/create', 'RecommendationController@create'); // id parameter is optional
Route::resource('recommendations', 'RecommendationController');

// Test Date controller
Route::get('surveys/{id?}/create', 'TestDateController@create'); // machineId parameter is optional
Route::get('surveys/addReport', 'TestDateController@addSurveyReport');
Route::put('surveys/storeReport', 'TestDateController@storeSurveyReport');
Route::resource('surveys', 'TestDateController');

// Tube controller
Route::get('tubes/{id}/create', 'TubeController@create');
Route::resource('tubes', 'TubeController');

// Routes for managing the lookup tables
// Show index of machines grouped by location
Route::get('locations/', 'LocationController@showLocationIndex');
// List of machines for a selected location(s)
Route::get('locations/{id}', 'LocationController@showLocation');
Route::resource('admin/locations', 'LocationController');

// Show index of machines grouped by manufacturer
Route::get('manufacturers/', 'ManufacturerController@showManufacturerIndex');
// List of machines for a selected modality/modalities
Route::get('manufacturers/{id}', 'ManufacturerController@showManufacturer');
Route::resource('admin/manufacturers', 'ManufacturerController');

// Show index of machines grouped by modality
Route::get('modalities/', 'ModalityController@showModalityIndex');
// List of machines for a selected modality/modalities
Route::get('modalities/{id}', 'ModalityController@showModality');
Route::resource('admin/modalities', 'ModalityController');
Route::resource('admin/testers', 'TesterController');
Route::resource('admin/testtypes', 'TestTypeController');

// Route for user management
Route::resource('users', 'UserController');

// Route for experiments and tests
Route::resource('test', 'TestController');

Auth::routes();

Route::get('/home', 'HomeController@index');
