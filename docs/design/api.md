# Radiology Equipment Database API Endpoints

## Dashboards
These URIs are used to show status dashboards

/ - Main index page for the equipment database. This page has three sections that list machines that need to be surveyed, scheduled surveys, and the survey schedule.

/dashboard

/teststatus - This is the same as /dashboard. Internally this is a redirect to /dashbaord

/surveycount/{*yr*} - Displays a bar chart showing the number of surveys in each month for the year specified by *yr*

## X-ray Equipment Inventory Listings
These URIs are used to show listings of the active equipment currently tracked in the database.

/machines (GET) - Listing of all the active machines tracked in the database

/machines/{*id*} (GET) - Shows information for a specific machine specified by *id*. *id* is an integer which maps to the id column in the machines table. If an *id* is specified that is not present in the database, a 404 error is returned. Information returned consists of the x-ray unit information, x-ray tube information and a list of surveys associated with the unit.

/machines/modalities (GET) - Presents a listing of all active machines in the database (similar to /machines) grouped by modality.

/machines/modalities/{*id*} (GET) - Presents a listing of all active machines in the database for a specific modality specified by *id*. *id* is an integer which maps to the id column in the *modalities* table through the *modality_id* column in the *machines* table. If an *id* is specified that is not present in the database, a 404 error is returned.

/machines/locations (GET) - Presents a listing of all active machines in the database (similar to /machines) grouped by locations

/machines/locations/{*id*} (GET) - Presents a listing of all active machines in the database for a specific location specified by *id*. *id* is an integer which maps to the id column in the *locations* table through the *location_id* column in the *machines* table. If an *id* is specified that is not present in the database, a 4040 error is returned.

/machines/create (GET) - Present a form for adding a new machine. Handled by MachineController@create

/machines (POST) - Routed to the MachineController@store method to store the machine information from the /machines/create form

/machines/{*id*}/edit - Present a form allowing the user to edit the information for the machine specified by *id*. Handled by MachineController@edit

/machines/{*id*} (PUT) - Routed to the MachineController@update method to update the machine info from the /machines/{*id*}/edit form

/recommendations/{*id*} (GET) - Presents a listing of survey recommendations for a specified survey *id*

## API related functions
/machines/{*id*}/recommendations (GET) - Returns an [Eloquent collection](https://laravel.com/docs/5.3/eloquent-collections) containing a list of all the recommendations for a specific machine specified by *id*.

/machines/{*id*}/opnotes - Returns an [Eloquent collection](https://laravel.com/docs/5.3/eloquent-collections) containing a list of all the operational notes for a specific machine specified by *id*.

/machines/{*id*}/gendata - Returns an [Eloquent collection](https://laravel.com/docs/5.3/eloquent-collections) containing a list of all the generator check data for a specific machine specified by *id*.

/machines/{*id*}/tubes - Returns an [Eloquent collection](https://laravel.com/docs/5.3/eloquent-collections) containing a list of all active x-ray tubes for a specific machine identified by *id*.

## Administrative operations
These URIs are used for maintaining the tables used as lookup tables by other tables

/locations (GET) - Listing of locations tracked in the database

/locations/{*id*}/edit (GET) - Form for editing location *id*

/manufacturers (GET) - Listing of manufacturers tracked in the database

/manufacturers/{*id*}/edit (GET) - Form for editing manufacturer *id*

/modalities (GET) - Listing of modalities tracked in the database

/modalities/{*id}/edit (GET) - Form for editing modality *id*

/testers (GET) - Listing of testers tracked in the database

/testers/{*id*}/edit (GET) - Form for editing tester *id*

/testtypes (GET) - Listing of test types in the database

/testtypes/{*id*}/edit (GET) - Form for editing test type *id*
