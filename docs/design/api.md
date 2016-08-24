# Radiology Equipment Database API Endpoints

## Dashboards
These URIs are used to show status dashboards

/ - Main index page for the equipment database. This page has three sections that list machines that need to be surveyed, scheduled surveys, and the survey schedule.

/dashboard

/teststatus - This is the same as /dashboard. Internally this is a redirect to /dashbaord

/surveycount/{*yr*} - Displays a bar chart showing the number of surveys in each month for the year specified by *yr*

## X-ray Equipment Inventory Listings
These URIs are used to show listings of the active equipment currently tracked
in the database.

/machines - Listing of all the active machines tracked in the database

/machines/{*id*} - Shows information for a specific machine specified by *id*. *id* is an integer which maps to the id column in the machines table. If an *id* is specified that is not present in the database, a 404 error is returned. Information returned consists of the x-ray unit information, x-ray tube information and a list of surveys associated with the unit.

/machines/modalities - Presents a listing of all active machines in the database (similar to /machines) grouped by modality.

/machines/modalities/{*id*} - Presents a listing of all active machines in the database for a specific modality specified by *id*. *id* is an integer which maps to the id column in the *modalities* table through the *modality_id* column in the *machines* table. If an *id* is specified that is not present in the database, a 404 error is returned.

/machines/locations/ - Presents a listing of all active machines in the database (similar to /machines) grouped by locations

/machines/locations/{*id*} - Presents a listing of all active machines in the database for a specific location specified by *id*. *id* is an integer which maps to the id column in the *locations* table through the *location_id* column in the *machines* table. If an *id* is specified that is not present in the database, a 4040 error is returned.

/machines/{*id*}/recommendations - Returns an [Eloquent collection](https://laravel.com/docs/5.3/eloquent-collections) containing a list of all the recommendations for a specific machine specified by *id*.

/machines/{*id*}/opnotes - Returns an [Eloquent collection](https://laravel.com/docs/5.3/eloquent-collections) containing a list of all the operational notes for a specific machine specified by *id*.

/machines/{*id*}/gendata - Returns an [Eloquent collection](https://laravel.com/docs/5.3/eloquent-collections) containing a list of all the generator check data for a specific machine specified by *id*.

/machines/{*id*}/tubes - Returns an [Eloquent collection](https://laravel.com/docs/5.3/eloquent-collections) containing a list of all active x-ray tubes for a specific machine identified by *id*.

/recommendations/{*id*} - Presents a listing of survey recommendations for a specified survey *id*
