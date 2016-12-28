# Routes
Routes that will/could be used in the raddb application

## Dashboards

|Method|Route|Description|Status|
|------|-----|-----------|------|
|GET | / | Main index / Survey schedule | Basic implementation |
|GET | /dashboard | Equipment testing status dashboard ||
|GET | /surveycount/:yr | Graph counts of surveys by month for a selected year ||


## Inventory Reporting
These routes go to pages used to display information about the machines tracked in the database

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /machines | List all machines | Basic implementation |
| GET | /machines/:id | Display details for a specific machine | Basic implementation |
| GET | /machines/modalities | List all machines by modality | Basic implementation |
| GET | /machines/modalities/:id | List machines for specific a specific modality | Basic implementation |
| GET | /machines/locations | List all machines by location | Basic implementation |
| GET | /machines/locations/:id | List all machines for a specific location(s) | Basic implementation |
| GET | /machines/:id/recommendations | Retrieve recommendations for a specific machine | Basic implementation |
| GET | /machines/:id/opnotes | Retrieve operational notes for a specific machine | Basic implementation |
| GET | /machines/:id/gendata | Retrieve generator check data for a specific machine | Basic implementation |
| GET | /machines/:id/tubes | Retrieve x-ray tubes for a specific machine | Basic implementation |

## Inventory manipulation

### Machines
These routes go to pages used to add, edit or delete machines

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /machines/create | Form to create a new machine | Basic implementation. |
| POST | /machines | Handle creation of new machine| Basic implementation. ** Needs confirmation dialog** |
| GET | /machines/:id/edit | Form to edit an existing machine identified by :id | Basic implementation. **Needs testing** |
| PUT | /machines/:id | Handle updates to machine :id | Basic implementation. **Needs testing** |
| GET | /machines/:id/delete | Form to confirm deletion of machine :id ||
| DELETE | /machines/:id | Handle deletion of machine :id | Basic implementation. **Needs authentication** |

### X-ray tubes
These routes go to pages used to add, edit or delete x-ray tubes.

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /tubes/:id/create | Form to add a new x-ray tube for machine identified by :id | Basic implementation. |
| POST | /tubes | Handle creation of new x-ray tube | Basic implementation. ** Needs confirmation dialog** |
| GET | /tubes/:id/edit | Form to edit an existing x-ray tube | Basic implementation.|
| PUT | /tubes/:id | Handle updates to x-ray tube :id | Basic implementation. |
| GET | /tubes/:id/delete | Form to confirm deletion of x-ray tube :id ||
| DELETE | /tubes/:id | Handle deletion of x-ray tube :id | |

### Operational notes
Operational notes are displayed with the machine details (/machines/:id). The only routes we need are ones to handle creating new operational notes for an existing machine

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /opnotes/machine/:id/create | Create a new operational note ||
| POST | /opnotes/machine/:id | Handle creation of an operational note ||

## Survey manipulation

### Surveys
These routes go to pages used to create or edit survey information

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /surveys/create | Form to add a new survey | Basic implementation|
| GET | /surveys/:id/create | Form to add a new survey for machine *id* | Basic implementation |
| POST | /surveys | Handle creation of a new survey | Basic implementation |
| GET | /surveys/:id/edit | Form to edit a survey (usually for date editing)||
| PUT | /surveys/:id | Handle updates to survey :id ||

### Survey recommendations
These routes go to pages used to add or edit survey recommendations

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /recommendations/create | Form to add a survey recommendation | Basic implementation |
| POST | /recommendations | Handle adding survey recommendation | Basic implementation |
| GET | /recommendations/:id/edit | Form to handle resolving survey recommendations| Basic implementation |
| GET | /recommendations/:id | Display a list of survey recommendations | Basic implementation |
| PUT | /recommendations/:id | Handle resolving survey recommendation | Basic implementation |

## Survey reporting
These routes go to pages used to display lists of surveys or recommendations

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /surveys | Show list of currently scheduled surveys ||
| GET | /surveys/machine/:machine_id | Show list of surveys for a specific machine ||
| GET | /surveys/recommendations/unresolved | List unresolved recommendations ||

## Lookup table manipulation
These routes are used to maintain lookup tables used by other tables

### Locations table
Locations where equipment is found

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/locations | List locations | Basic implementation |
| POST | /admin/locations | Add a new location | Basic implementation |
| GET | /admin/locations/:id/edit | Form to edit a location | Basic implementation |
| PUT | /admin/locations/:id | Handle updates to a location | Basic implementation |
| DELETE | /admin/locations/:id | Handle deleting a location | Basic implementation. **Needs authentication** |

### Manufacturers
Equipment manufacturers

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/manufacturers | List manufacturers | Basic implementation |
| POST | /admin/manufacturers | Add a new manufacturer | Basic implementation |
| GET | /admin/manufacturers/:id/edit | Form to edit a manufacturer | Basic implementation |
| PUT | /admin/manufacturers/:id | Handle updates to a manufacturer | Basic implementation |
| DELETE | /admin/manufacturers/:id | Handle deleting a manufacturer | Basic implementation. **Needs authentication** |

### Modalities
Imaging modalities

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/modalities | List modalities | Basic implementation |
| POST | /admin/modalities | Add a new modality | Basic implementation |
| GET | /admin/modalities/:id/edit | Form to edit a modality | Basic implementation |
| PUT | /admin/modalities/:id | Handle updates to a modality | Basic implementation |
| DELETE | /admin/modalities/:id | Handle deleting a modality | Basic implementation. **Needs authentication** |

### Testers
People who test the equipment

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/testers | List testers | Basic implementation |
| POST | /admin/testers | Add a new tester | Basic implementation |
| GET | /admin/testers/:id/edit | Form to edit a tester | Basic implementation |
| PUT | /admin/testers/:id | Handle updates to a tester | Basic implementation |
| DELETE | /admin/testers/:id | Handle deleting a tester | Basic implementation. **Needs authentication** |

### Test types
Types of testing

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/testtypes | List test types | Basic implementation |
| POST | /admin/testtypes | Add a new test type | Basic implementation |
| GET | /admin/testtypes/:id/edit | Form to edit a test type | Basic implementation |
| PUT | /admin/testtypes/:id | Handle updates to a test type | Basic implementation |
| DELETE | /admin/testtypes/:id | Handle deleting a test type | Basic implementation. **Needs authentication** |

-------------------

+--------+-----------+-----------------------------------------+-------------------------+--------------------------------------------------------------+------------+
| Domain | Method    | URI                                     | Name                    | Action                                                       | Middleware |
+--------+-----------+-----------------------------------------+-------------------------+--------------------------------------------------------------+------------+
|        | GET|HEAD  | /                                       |                         | RadDB\Http\Controllers\DashboardController@index             | web        |
|        | GET|HEAD  | admin/locations                         | locations.index         | RadDB\Http\Controllers\LocationController@index              | web        |
|        | POST      | admin/locations                         | locations.store         | RadDB\Http\Controllers\LocationController@store              | web        |
|        | GET|HEAD  | admin/locations/create                  | locations.create        | RadDB\Http\Controllers\LocationController@create             | web        |
|        | PUT|PATCH | admin/locations/{location}              | locations.update        | RadDB\Http\Controllers\LocationController@update             | web        |
|        | DELETE    | admin/locations/{location}              | locations.destroy       | RadDB\Http\Controllers\LocationController@destroy            | web        |
|        | GET|HEAD  | admin/locations/{location}              | locations.show          | RadDB\Http\Controllers\LocationController@show               | web        |
|        | GET|HEAD  | admin/locations/{location}/edit         | locations.edit          | RadDB\Http\Controllers\LocationController@edit               | web        |
|        | GET|HEAD  | admin/manufacturers                     | manufacturers.index     | RadDB\Http\Controllers\ManufacturerController@index          | web        |
|        | POST      | admin/manufacturers                     | manufacturers.store     | RadDB\Http\Controllers\ManufacturerController@store          | web        |
|        | GET|HEAD  | admin/manufacturers/create              | manufacturers.create    | RadDB\Http\Controllers\ManufacturerController@create         | web        |
|        | DELETE    | admin/manufacturers/{manufacturer}      | manufacturers.destroy   | RadDB\Http\Controllers\ManufacturerController@destroy        | web        |
|        | PUT|PATCH | admin/manufacturers/{manufacturer}      | manufacturers.update    | RadDB\Http\Controllers\ManufacturerController@update         | web        |
|        | GET|HEAD  | admin/manufacturers/{manufacturer}      | manufacturers.show      | RadDB\Http\Controllers\ManufacturerController@show           | web        |
|        | GET|HEAD  | admin/manufacturers/{manufacturer}/edit | manufacturers.edit      | RadDB\Http\Controllers\ManufacturerController@edit           | web        |
|        | POST      | admin/modalities                        | modalities.store        | RadDB\Http\Controllers\ModalityController@store              | web        |
|        | GET|HEAD  | admin/modalities                        | modalities.index        | RadDB\Http\Controllers\ModalityController@index              | web        |
|        | GET|HEAD  | admin/modalities/create                 | modalities.create       | RadDB\Http\Controllers\ModalityController@create             | web        |
|        | PUT|PATCH | admin/modalities/{modality}             | modalities.update       | RadDB\Http\Controllers\ModalityController@update             | web        |
|        | GET|HEAD  | admin/modalities/{modality}             | modalities.show         | RadDB\Http\Controllers\ModalityController@show               | web        |
|        | DELETE    | admin/modalities/{modality}             | modalities.destroy      | RadDB\Http\Controllers\ModalityController@destroy            | web        |
|        | GET|HEAD  | admin/modalities/{modality}/edit        | modalities.edit         | RadDB\Http\Controllers\ModalityController@edit               | web        |
|        | POST      | admin/testers                           | testers.store           | RadDB\Http\Controllers\TesterController@store                | web        |
|        | GET|HEAD  | admin/testers                           | testers.index           | RadDB\Http\Controllers\TesterController@index                | web        |
|        | GET|HEAD  | admin/testers/create                    | testers.create          | RadDB\Http\Controllers\TesterController@create               | web        |
|        | DELETE    | admin/testers/{tester}                  | testers.destroy         | RadDB\Http\Controllers\TesterController@destroy              | web        |
|        | PUT|PATCH | admin/testers/{tester}                  | testers.update          | RadDB\Http\Controllers\TesterController@update               | web        |
|        | GET|HEAD  | admin/testers/{tester}                  | testers.show            | RadDB\Http\Controllers\TesterController@show                 | web        |
|        | GET|HEAD  | admin/testers/{tester}/edit             | testers.edit            | RadDB\Http\Controllers\TesterController@edit                 | web        |
|        | POST      | admin/testtypes                         | testtypes.store         | RadDB\Http\Controllers\TestTypeController@store              | web        |
|        | GET|HEAD  | admin/testtypes                         | testtypes.index         | RadDB\Http\Controllers\TestTypeController@index              | web        |
|        | GET|HEAD  | admin/testtypes/create                  | testtypes.create        | RadDB\Http\Controllers\TestTypeController@create             | web        |
|        | PUT|PATCH | admin/testtypes/{testtype}              | testtypes.update        | RadDB\Http\Controllers\TestTypeController@update             | web        |
|        | DELETE    | admin/testtypes/{testtype}              | testtypes.destroy       | RadDB\Http\Controllers\TestTypeController@destroy            | web        |
|        | GET|HEAD  | admin/testtypes/{testtype}              | testtypes.show          | RadDB\Http\Controllers\TestTypeController@show               | web        |
|        | GET|HEAD  | admin/testtypes/{testtype}/edit         | testtypes.edit          | RadDB\Http\Controllers\TestTypeController@edit               | web        |
|        | GET|HEAD  | api/machines/{id}/gendata               |                         | RadDB\Http\Controllers\MachineController@getGenData          | api        |
|        | GET|HEAD  | api/machines/{id}/opnotes               |                         | RadDB\Http\Controllers\MachineController@getOperationalNotes | api        |
|        | GET|HEAD  | api/machines/{id}/recommendations       |                         | RadDB\Http\Controllers\MachineController@getRecommendations  | api        |
|        | GET|HEAD  | api/machines/{id}/tubes                 |                         | RadDB\Http\Controllers\MachineController@getTubes            | api        |
|        | POST      | contacts                                | contacts.store          | RadDB\Http\Controllers\ContactController@store               | web        |
|        | GET|HEAD  | contacts                                | contacts.index          | RadDB\Http\Controllers\ContactController@index               | web        |
|        | GET|HEAD  | contacts/create                         | contacts.create         | RadDB\Http\Controllers\ContactController@create              | web        |
|        | DELETE    | contacts/{contact}                      | contacts.destroy        | RadDB\Http\Controllers\ContactController@destroy             | web        |
|        | PUT|PATCH | contacts/{contact}                      | contacts.update         | RadDB\Http\Controllers\ContactController@update              | web        |
|        | GET|HEAD  | contacts/{contact}                      | contacts.show           | RadDB\Http\Controllers\ContactController@show                | web        |
|        | GET|HEAD  | contacts/{contact}/edit                 | contacts.edit           | RadDB\Http\Controllers\ContactController@edit                | web        |
|        | GET|HEAD  | dashboard                               |                         | RadDB\Http\Controllers\DashboardController@teststatus        | web        |
|        | GET|HEAD  | gendata                                 | gendata.index           | RadDB\Http\Controllers\GenDataController@index               | web        |
|        | POST      | gendata                                 | gendata.store           | RadDB\Http\Controllers\GenDataController@store               | web        |
|        | GET|HEAD  | gendata/create                          | gendata.create          | RadDB\Http\Controllers\GenDataController@create              | web        |
|        | PUT|PATCH | gendata/{gendatum}                      | gendata.update          | RadDB\Http\Controllers\GenDataController@update              | web        |
|        | GET|HEAD  | gendata/{gendatum}                      | gendata.show            | RadDB\Http\Controllers\GenDataController@show                | web        |
|        | DELETE    | gendata/{gendatum}                      | gendata.destroy         | RadDB\Http\Controllers\GenDataController@destroy             | web        |
|        | GET|HEAD  | gendata/{gendatum}/edit                 | gendata.edit            | RadDB\Http\Controllers\GenDataController@edit                | web        |
|        | POST      | machines                                | machines.store          | RadDB\Http\Controllers\MachineController@store               | web        |
|        | GET|HEAD  | machines                                | machines.index          | RadDB\Http\Controllers\MachineController@index               | web        |
|        | GET|HEAD  | machines/create                         | machines.create         | RadDB\Http\Controllers\MachineController@create              | web        |
|        | GET|HEAD  | machines/locations                      |                         | RadDB\Http\Controllers\MachineController@showLocationIndex   | web        |
|        | GET|HEAD  | machines/locations/{id}                 |                         | RadDB\Http\Controllers\MachineController@showLocation        | web        |
|        | GET|HEAD  | machines/modalities                     |                         | RadDB\Http\Controllers\MachineController@showModalityIndex   | web        |
|        | GET|HEAD  | machines/modalities/{id}                |                         | RadDB\Http\Controllers\MachineController@showModality        | web        |
|        | DELETE    | machines/{machine}                      | machines.destroy        | RadDB\Http\Controllers\MachineController@destroy             | web        |
|        | GET|HEAD  | machines/{machine}                      | machines.show           | RadDB\Http\Controllers\MachineController@show                | web        |
|        | PUT|PATCH | machines/{machine}                      | machines.update         | RadDB\Http\Controllers\MachineController@update              | web        |
|        | GET|HEAD  | machines/{machine}/edit                 | machines.edit           | RadDB\Http\Controllers\MachineController@edit                | web        |
|        | GET|HEAD  | opnotes                                 | opnotes.index           | RadDB\Http\Controllers\OpNoteController@index                | web        |
|        | POST      | opnotes                                 | opnotes.store           | RadDB\Http\Controllers\OpNoteController@store                | web        |
|        | GET|HEAD  | opnotes/create                          | opnotes.create          | RadDB\Http\Controllers\OpNoteController@create               | web        |
|        | DELETE    | opnotes/{opnote}                        | opnotes.destroy         | RadDB\Http\Controllers\OpNoteController@destroy              | web        |
|        | PUT|PATCH | opnotes/{opnote}                        | opnotes.update          | RadDB\Http\Controllers\OpNoteController@update               | web        |
|        | GET|HEAD  | opnotes/{opnote}                        | opnotes.show            | RadDB\Http\Controllers\OpNoteController@show                 | web        |
|        | GET|HEAD  | opnotes/{opnote}/edit                   | opnotes.edit            | RadDB\Http\Controllers\OpNoteController@edit                 | web        |
|        | GET|HEAD  | recommendations                         | recommendations.index   | RadDB\Http\Controllers\RecommendationController@index        | web        |
|        | POST      | recommendations                         | recommendations.store   | RadDB\Http\Controllers\RecommendationController@store        | web        |
|        | GET|HEAD  | recommendations/create                  | recommendations.create  | RadDB\Http\Controllers\RecommendationController@create       | web        |
|        | GET|HEAD  | recommendations/{id?}/create            |                         | RadDB\Http\Controllers\RecommendationController@create       | web        |
|        | DELETE    | recommendations/{recommendation}        | recommendations.destroy | RadDB\Http\Controllers\RecommendationController@destroy      | web        |
|        | PUT|PATCH | recommendations/{recommendation}        | recommendations.update  | RadDB\Http\Controllers\RecommendationController@update       | web        |
|        | GET|HEAD  | recommendations/{recommendation}        | recommendations.show    | RadDB\Http\Controllers\RecommendationController@show         | web        |
|        | GET|HEAD  | recommendations/{recommendation}/edit   | recommendations.edit    | RadDB\Http\Controllers\RecommendationController@edit         | web        |
|        | GET|HEAD  | surveycount/{yr}                        |                         | RadDB\Http\Controllers\DashboardController@surveycount       | web        |
|        | POST      | surveys                                 | surveys.store           | RadDB\Http\Controllers\TestDateController@store              | web        |
|        | GET|HEAD  | surveys                                 | surveys.index           | RadDB\Http\Controllers\TestDateController@index              | web        |
|        | GET|HEAD  | surveys/create                          | surveys.create          | RadDB\Http\Controllers\TestDateController@create             | web        |
|        | PUT       | surveys/storeReport                     |                         | RadDB\Http\Controllers\TestDateController@storeSurveyReport  | web        |
|        | GET|HEAD  | surveys/{id?}/addReport                 |                         | RadDB\Http\Controllers\TestDateController@addSurveyReport    | web        |
|        | GET|HEAD  | surveys/{id?}/create                    |                         | RadDB\Http\Controllers\TestDateController@create             | web        |
|        | DELETE    | surveys/{survey}                        | surveys.destroy         | RadDB\Http\Controllers\TestDateController@destroy            | web        |
|        | GET|HEAD  | surveys/{survey}                        | surveys.show            | RadDB\Http\Controllers\TestDateController@show               | web        |
|        | PUT|PATCH | surveys/{survey}                        | surveys.update          | RadDB\Http\Controllers\TestDateController@update             | web        |
|        | GET|HEAD  | surveys/{survey}/edit                   | surveys.edit            | RadDB\Http\Controllers\TestDateController@edit               | web        |
|        | POST      | test                                    | test.store              | RadDB\Http\Controllers\TestController@store                  | web        |
|        | GET|HEAD  | test                                    | test.index              | RadDB\Http\Controllers\TestController@index                  | web        |
|        | GET|HEAD  | test/create                             | test.create             | RadDB\Http\Controllers\TestController@create                 | web        |
|        | PUT|PATCH | test/{test}                             | test.update             | RadDB\Http\Controllers\TestController@update                 | web        |
|        | DELETE    | test/{test}                             | test.destroy            | RadDB\Http\Controllers\TestController@destroy                | web        |
|        | GET|HEAD  | test/{test}                             | test.show               | RadDB\Http\Controllers\TestController@show                   | web        |
|        | GET|HEAD  | test/{test}/edit                        | test.edit               | RadDB\Http\Controllers\TestController@edit                   | web        |
|        | GET|HEAD  | teststatus                              |                         | RadDB\Http\Controllers\DashboardController@teststatus        | web        |
|        | POST      | tubes                                   | tubes.store             | RadDB\Http\Controllers\TubeController@store                  | web        |
|        | GET|HEAD  | tubes                                   | tubes.index             | RadDB\Http\Controllers\TubeController@index                  | web        |
|        | GET|HEAD  | tubes/create                            | tubes.create            | RadDB\Http\Controllers\TubeController@create                 | web        |
|        | GET|HEAD  | tubes/{machineID}/create                |                         | RadDB\Http\Controllers\TubeController@create                 | web        |
|        | PUT|PATCH | tubes/{tube}                            | tubes.update            | RadDB\Http\Controllers\TubeController@update                 | web        |
|        | GET|HEAD  | tubes/{tube}                            | tubes.show              | RadDB\Http\Controllers\TubeController@show                   | web        |
|        | DELETE    | tubes/{tube}                            | tubes.destroy           | RadDB\Http\Controllers\TubeController@destroy                | web        |
|        | GET|HEAD  | tubes/{tube}/edit                       | tubes.edit              | RadDB\Http\Controllers\TubeController@edit                   | web        |
+--------+-----------+-----------------------------------------+-------------------------+--------------------------------------------------------------+------------+
