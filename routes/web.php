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

/*
 * Dashboard routes
 */
Route::name('index')->get('/', 'DashboardController@index'); // Survey schedule
Route::name('dashboard.dashboard')
    ->get('/dashboard', 'DashboardController@teststatus');
// Untested machines
Route::name('dashboard.showUntested')
    ->get('/dashboard/showUntested', 'DashboardController@showUntested');
// Pending surveys
Route::name('dashboard.showPending')
    ->get('/dashboard/showPending', 'DashboardController@showPending');
// Survey schedule
Route::name('dashboard.showSchedule')
    ->get('/dashboard/showSchedule', 'DashboardController@showSchedule');
// Count of surveys per month
// Route::name('dashboard.surveyGraph')
//     ->get('/dashboard/surveyGraph', 'DashboardController@surveyGraph');

/*
 * Machine listings
 */
// Inactive machines
Route::name('machines.inactive')
    ->get('/machines/inactive', 'MachineListingController@showInactive');
// Removed machines
Route::name('machines.removed')
    ->get('/machines/removed/{year?}', 'MachineListingController@showRemoved');
// Installed machines by year
Route::name('machines.installed')
    ->get('/machines/installed/{year?}', 'MachineListingController@showInstalled');
// Index of machines grouped by location
Route::name('machines.showLocationIndex')
    ->get('/machines/locations', 'LocationController@index');
// List of machines for a selected location(s)
Route::name('machines.showLocation')
    ->get('/machines/locations/{id}', 'LocationController@show');
// Index of machines grouped by manufacturer
Route::name('machines.showManufacturerIndex')
    ->get('/machines/manufacturers', 'ManufacturerController@index');
// List of machines for a selected modality/modalities
Route::name('machines.showManufacturer')
    ->get('/machines/manufacturers/{id}', 'ManufacturerController@show');
// Index of machines grouped by modality
Route::name('machines.showModalityIndex')
    ->get('/machines/modalities', 'ModalityController@index');
// List of machines for a selected modality/modalities
Route::name('machines.showModality')
    ->get('/machines/modalities/{id}', 'ModalityController@show');

/*
 * Machine controller
 */
Route::resource('machines', 'MachineController');

/*
 * Test equipment controller
 */
Route::name('testequipment.showCalDates')
    ->get('/testequipment/caldates', 'TestEquipmentController@showCalDates');
Route::resource('testequipment', 'TestEquipmentController');

/*
 * Operational notes controller
 */
Route::name('opnotes.createOpNoteFor')
    ->get('opnotes/{machineId?}/create', 'OpNoteController@create');
Route::resource('opnotes', 'OpNoteController');

/*
 * Recommendation controller
 */
Route::name('recommendations.createRecFor')
    ->get('recommendations/{id?}/create', 'RecommendationController@create');
Route::resource('recommendations', 'RecommendationController');

/*
 * Test Date controller
 */
Route::name('surveys.createSurveyFor')
    ->get('surveys/{id?}/create', 'TestDateController@create');
Route::resource('surveys', 'TestDateController');

/*
 * Survey report controller
 */
Route::name('surveyreports.create')
    ->get('surveyreports/{id?}/create', 'SurveyReportController@create');
Route::resource('surveyreports', 'SurveyReportController');

/*
 * Service report controller
 */
Route::resource('servicereports', 'ServiceReportController');

/*
 * Tube controller
 */
Route::name('tubes.createTubeFor')->get('tubes/{id}/create', 'TubeController@create');
Route::resource('tubes', 'TubeController');

/*
 * Photos controller. Used to handle uploading and updating photos of machines.
 */
Route::name('photos.create')
    ->get('photos/{id}/create', 'MachinePhotoController@create');
Route::resource('photos', 'MachinePhotoController',
    ['except' => ['create']]);

/*
 * Mammography CE controller
 */
Route::name('mammo.CE')
    ->get('mammo/{tester_id}/show', 'MammoCEController@show');

/*
 * Route for user management
 */
Route::resource('users', 'UserController');

/*
 * Authentication routes
 */
Auth::routes();
Route::name('home.index')->get('/home', 'HomeController@index');

/*
 * Routes for viewing QA/survey data
 */
Route::name('qa.index')->get('qa/', 'QAController@index');
Route::name('qa.machineSurveyList')->get('qa/{machine_id}/surveyList', 'QAController@show');

/*
 * Survey test data routes
 */
Route::name('gendata.create')
    ->get('surveydata/generator/{surveyId}/create', 'GenDataController@create');
Route::resource('gendata', 'GenDataController',
                ['except' => ['create']]);
Route::resource('collimatordata', 'CollimatorDataController');
Route::resource('fluorodata', 'FluoroDataController');
Route::resource('hvldata', 'HVLDataController');
Route::resource('maxfluorodata', 'MaxFluoroDataController');
Route::resource('radsurveydata', 'RadSurveyDataController');
Route::resource('radoutputdata', 'RadiationOutputController');
Route::resource('receptorentrance', 'ReceptorEntranceExpController');

// CT Daily QC routes
Route::resource('ctdailyqc', 'CTDailyQCRecordController');

/*
 * Reporting routes
 */
Route::name('ar.effort')->get('/ar/effort', 'ARController@effort');
Route::name('ar.cexp')->get('/ar/cexp', 'CExpController@cexp');
