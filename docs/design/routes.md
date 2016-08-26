# Routes
Routes that will/could be used in the raddb application

## Dashboards

|Method|Route|Description|Status|
|------|-----|-----------|------|
|GET | / | Main index / Survey schedule ||
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
| GET | /machines/create | Form to create a new machine ||
| POST | /machines | Handle creation of new machine||
| GET | /machines/:id/edit | Form to edit an existing machine identified by :id ||
| PUT | /machines/:id | Handle updates to machine :id ||
| GET | /machines/:id/delete | Form to confirm deletion of machine :id ||
| DELETE | /machines/:id | Handle deletion of machine :id ||

### X-ray tubes
These routes go to pages used to add, edit or delete x-ray tubes.

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /tubes/:id/create | Form to add a new x-ray tube for machine identified by :id ||
| POST | /tubes | Handle creation of new x-ray tube ||
| GET | /tubes/:id/edit | Form to edit an existing x-ray tube ||
| PUT | /tubes/:id | Handle updates to x-ray tube :id ||
| GET | /tubes/:id/delete | Form to confirm deletion of x-ray tube :id ||
| DELETE | /tubes/:id | Handle deletion of x-ray tube :id ||

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
| GET | /surveys/create | Form to add a new survey ||
| POST | /surveys | Handle creation of a new survey ||
| GET | /surveys/:id/edit | Form to edit a survey (usually for date editing)||
| PUT | /surveys/:id | Handle updates to survey :id ||

### Survey recommendations
These routes go to pages used to add or edit survey recommendations

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /recommendations/create | Form to add a survey recommendation ||
| POST | /recommendations | Handle adding survey recommendation ||
| GET | /recommendations/:id/edit | Form to handle resolving survey recommendations||
| GET | /recommendations/:id | Display a list of survey recommendations ||
| PUT | /recommendations/:id | Handle resolving survey recommendation ||

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
| POST | /admin/locations | Add a new location ||
| GET | /admin/locations/:id/edit | Form to edit a location ||
| PUT | /admin/locations/:id | Handle updates to a location ||

### Manufacturers
Equipment manufacturers

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/manufacturers | List manufacturers | Basic implementation |
| POST | /admin/manufacturers | Add a new manufacturer ||
| GET | /admin/manufacturers/:id/edit | Form to edit a manufacturer ||
| PUT | /admin/manufacturers/:id | Handle updates to a manufacturer ||

### Modalities
Imaging modalities

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/modalities | List modalities | Basic implementation |
| POST | /admin/modalities | Add a new modality ||
| GET | /admin/modalities/:id/edit | Form to edit a modality ||
| PUT | /admin/modalities/:id | Handle updates to a modality ||

### Testers
People who test the equipment

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/testers | List testers | Basic implementation |
| POST | /admin/testers | Add a new tester ||
| GET | /admin/testers/:id/edit | Form to edit a tester ||
| PUT | /admin/testers/:id | Handle updates to a tester ||

### Test types
Types of testing

|Method|Route|Description|Status|
|------|-----|-----------|------|
| GET | /admin/testtypes | List test types | Basic implementation |
| POST | /admin/testtypes | Add a new test type ||
| GET | /admin/testtypes/:id/edit | Form to edit a test type ||
| PUT | /admin/testtypes/:id | Handle updates to a test type ||
