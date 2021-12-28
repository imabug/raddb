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

use App\Http\Controllers\AnnReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MachinePhotoController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\ModalityController;
use App\Http\Controllers\OpNoteController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ServiceReportController;
use App\Http\Controllers\SurveyReportController;
use App\Http\Controllers\TestDateController;
use App\Http\Controllers\TestEquipmentController;
use App\Http\Controllers\TubeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
 * Dashboard routes
 */
// Survey schedule
Route::name('index')
    ->get('/', [DashboardController::class, 'index']);
Route::name('dashboard.dashboard')
    ->get('/dashboard', [DashboardController::class, 'teststatus']);
Route::name('dashboard.survey_graph')
    ->get('/dashboard/surveyCount', [DashboardController::class, 'showSurveyCounts']);

/*
 * Machine listings
 * These are redundant now that the machine listings has sorting and filtering capabilities
 * Will eventually be removed.
 */
// Inactive machines
// Route::name('machines.inactive')
//     ->get('/machines/inactive', [MachineListingController::class, 'showInactive']);
// // Removed machines
// Route::name('machines.removed')
//     ->get('/machines/removed/{year?}', [MachineListingController::class, 'showRemoved']);
// // Installed machines by year
// Route::name('machines.installed')
//     ->get('/machines/installed/{year?}', [MachineListingController::class, 'showInstalled']);
// // Index of machines grouped by location
// Route::name('machines.showLocationIndex')
//     ->get('/machines/locations', [LocationController::class, 'index']);
// // List of machines for a selected location(s)
// Route::name('machines.showLocation')
//     ->get('/machines/locations/{id}', [LocationController::class, 'show']);
// // Index of machines grouped by manufacturer
// Route::name('machines.showManufacturerIndex')
//     ->get('/machines/manufacturers', [ManufacturerController::class, 'index']);
// // List of machines for a selected modality/modalities
// Route::name('machines.showManufacturer')
//     ->get('/machines/manufacturers/{id}', [ManufacturerController::class, 'show']);
// // Index of machines grouped by modality
// Route::name('machines.showModalityIndex')
//     ->get('/machines/modalities', [ModalityController::class, 'index']);
// // List of machines for a selected modality/modalities
// Route::name('machines.showModality')
//     ->get('/machines/modalities/{id}', [ModalityController::class, 'show']);

/*
 * Machine controller
 */
Route::resource('machines', MachineController::class);

/*
 * Test equipment controller
 */
Route::name('testequipment.showCalDates')
    ->get('/testequipment/caldates', [TestEquipmentController::class, 'showCalDates']);
Route::resource('testequipment', TestEquipmentController::class);

/*
 * Operational notes controller
 */
Route::name('opnotes.operationalNotes')
    ->get('opnotes/opnotes/', \App\Http\Livewire\Opnotes\OperationalNotes::class);
Route::name('opnotes.createOpNoteFor')
    ->get('opnotes/{machineId?}/create', [OpNoteController::class, 'create']);
Route::resource('opnotes', OpNoteController::class);
/*
 * Recommendation controller
 */
Route::name('recommendations.createRecFor')
    ->get('recommendations/{id?}/create', [RecommendationController::class, 'create']);
Route::resource('recommendations', RecommendationController::class);

/*
 * Test Date controller
 */
Route::name('surveys.createSurveyFor')
    ->get('surveys/{id?}/create', [TestDateController::class, 'create']);
Route::resource('surveys', TestDateController::class);

/*
 * Survey report controller
 */
Route::name('surveyreports.create')
    ->get('surveyreports/create/{id?}', [SurveyReportController::class, 'create']);
Route::resource(
    'surveyreports',
    SurveyReportController::class,
    ['except' => ['create']]
);

/*
 * Service report controller
 */
Route::resource('servicereports', ServiceReportController::class);

/*
 * Tube controller
 */
Route::name('tubes.createTubeFor')
    ->get('tubes/{id}/create', [TubeController::class, 'create']);
Route::resource(
    'tubes',
    TubeController::class,
    ['except' => ['create']]
);

/*
 * Photos controller. Used to handle uploading and updating photos of machines.
 */
Route::name('photos.create')
    ->get('photos/{id}/create', [MachinePhotoController::class, 'create']);
Route::resource(
    'photos',
    MachinePhotoController::class,
    ['except' => ['create']]
);

/*
 * Route for user management
 */
Route::resource('users', UserController::class);

/*
 * Authentication routes
 */
Auth::routes();
Route::name('home.index')->get('/home', [HomeController::class, 'index']);

/*
 * Reporting routes
 */
Route::name('ar.cexp')->get('/ar/cexp', [AnnReportController::class, 'mammContExp']);
Route::name('ar.annrep')->get('ar/{year}/annrep/', [AnnReportController::class, 'annrep']);

// Experimental routes
//Route::name('test.testtables')->get('/test/testtables', ShowMachines::class);
