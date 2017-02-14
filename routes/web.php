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

// Route::get('/', function () {
//     return view('welcome');
// });

// Dashboard routes
Route::get('/', 'DashboardController@index')->name('index'); // Survey schedule
Route::get('/dashboard', 'DashboardController@teststatus')
    ->name('dashboard.dashboard'); // Equipment testing status dashboard
Route::get('/dashboard/showUntested', 'DashboardController@showUntested')
    ->name('dashboard.showUntested'); // Untested machines
Route::get('/dashboard/showPending', 'DashboardController@showPending')
    ->name('dashboard.showPending'); // Pending surveys
Route::get('/dashboard/showSchedule', 'DashboardController@showSchedule')
    ->name('dashboard.showSchedule'); // Survey schedule
Route::get('/dashboard/surveyGraph', 'DashboardController@surveyGraph')
    ->name('dashboard.surveyGraph'); // Count of surveys per month

// Machine controller
Route::get('/machines/inactive', 'MachineController@showInactive')
    ->name('machines.inactive'); // Listing of inactive machines
Route::get('/machines/removed', 'MachineController@showRemoved')
    ->name('machines.removed'); // Listing of removed machines
Route::resource('machines', 'MachineController');

// Test equipment controller
Route::get('/testequipment/caldates', 'TestEquipmentController@showCalDates')
    ->name('testequipment.showCalDates');
Route::resource('testequipment', 'TestEquipmentController');

// Contacts controller - deprecated from previous version
// Route::resource('contacts', 'ContactController');

// Generator data controller - haven't decided whether to  keep this or not
// Route::resource('gendata', 'GenDataController');

// Operational notes controller
Route::get('opnotes/{$id}/create', 'OpNoteController@create')
    ->name('opnotes.createOpNoteFor');
Route::resource('opnotes', 'OpNoteController');

// Recommendation controller
Route::get('recommendations/{id?}/create', 'RecommendationController@create')
    ->name('recommendations.createRecFor'); // id parameter is optional
Route::resource('recommendations', 'RecommendationController');

// Test Date controller
Route::get('surveys/{id?}/create', 'TestDateController@create')
    ->name('surveys.createSurveyFor'); // id parameter is optional
Route::get('surveys/addReport', 'TestDateController@addSurveyReport')
    ->name('surveys.addSurveyReport');
Route::put('surveys/storeReport', 'TestDateController@storeSurveyReport')
    ->name('surveys.storeSurveyReport');
Route::resource('surveys', 'TestDateController');

// Tube controller
Route::get('tubes/{id}/create', 'TubeController@create')
    ->name('tubes.createTubeFor');
Route::resource('tubes', 'TubeController');

// Routes for managing the lookup tables
// Location controller
Route::get('locations/', 'LocationController@showLocationIndex')
    ->name('locations.showLocationIndex'); // Show index of machines grouped by location
Route::get('locations/{id}', 'LocationController@showLocation')
    ->name('locations.showLocation'); // List of machines for a selected location(s)
Route::resource('admin/locations', 'LocationController');

// Manufacturer controller
Route::get('manufacturers/', 'ManufacturerController@showManufacturerIndex')
    ->name('manufacturers.showManufacturerIndex'); // Show index of machines grouped by manufacturer
Route::get('manufacturers/{id}', 'ManufacturerController@showManufacturer')
    ->name('manufacturers.showManufacturer'); // List of machines for a selected modality/modalities
Route::resource('admin/manufacturers', 'ManufacturerController');

// Modality controller
Route::get('modalities/', 'ModalityController@showModalityIndex')
    ->name('modalities.showModalityIndex'); // Show index of machines grouped by modality
Route::get('modalities/{id}', 'ModalityController@showModality')
    ->name('modalities.showModality'); // List of machines for a selected modality/modalities
Route::resource('admin/modalities', 'ModalityController');

// Testers controller
Route::resource('admin/testers', 'TesterController');

// Test types controller
Route::resource('admin/testtypes', 'TestTypeController');

// Reports controller
Route::get('reports/{type}/{id}', 'ReportController@show')
    ->name('reports.show');

// Route for user management
Route::resource('users', 'UserController');

// Route for experiments and tests
Route::resource('test', 'TestController');

// Authentication routes
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home.index');
