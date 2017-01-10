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
Route::get('/', 'DashboardController@index')->name('index');
// Equipment testing status dashboard
Route::get('/dashboard', 'DashboardController@teststatus')->name('dashboard.dashboard');
// Route::get('/teststatus',  'DashboardController@teststatus')->name('dashboard.status');

// Count of surveys per month for year $yr
Route::get('/surveycount/{yr}', 'DashboardController@surveycount')->name('dashboard.surveyCount');

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
Route::get('recommendations/{id?}/create', 'RecommendationController@create')->name('recommendations.createRecFor'); // id parameter is optional
Route::resource('recommendations', 'RecommendationController');

// Test Date controller
Route::get('surveys/{id?}/create', 'TestDateController@create')->name('surveys.createSurveyFor'); // machineId parameter is optional
Route::get('surveys/addReport', 'TestDateController@addSurveyReport')->name('surveys.addSurveyReport');
Route::put('surveys/storeReport', 'TestDateController@storeSurveyReport')->name('surveys.storeSurveyReport');
Route::resource('surveys', 'TestDateController');

// Tube controller
Route::get('tubes/{id}/create', 'TubeController@create')->name('tubes.createTubeFor');
Route::resource('tubes', 'TubeController');

// Routes for managing the lookup tables
// Show index of machines grouped by location
Route::get('locations/', 'LocationController@showLocationIndex')->name('locations.showLocationIndex');
// List of machines for a selected location(s)
Route::get('locations/{id}', 'LocationController@showLocation')->name('locations.showLocation');
Route::resource('admin/locations', 'LocationController');

// Show index of machines grouped by manufacturer
Route::get('manufacturers/', 'ManufacturerController@showManufacturerIndex')->name('manufacturers.showManufacturerIndex');
// List of machines for a selected modality/modalities
Route::get('manufacturers/{id}', 'ManufacturerController@showManufacturer')->name('manufacturers.showManufacturer');
Route::resource('admin/manufacturers', 'ManufacturerController');

// Show index of machines grouped by modality
Route::get('modalities/', 'ModalityController@showModalityIndex')->name('modalities.showModalityIndex');
// List of machines for a selected modality/modalities
Route::get('modalities/{id}', 'ModalityController@showModality')->name('modalities.showModality');
Route::resource('admin/modalities', 'ModalityController');
Route::resource('admin/testers', 'TesterController');
Route::resource('admin/testtypes', 'TestTypeController');

Route::get('reports/{type}/{id}', 'ReportController@show')->name('reports.show');

// Route for user management
Route::resource('users', 'UserController');

// Route for experiments and tests
Route::resource('test', 'TestController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home.index');
