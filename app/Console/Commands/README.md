# RadDB Commands

## Import commands
Commands to import test data from the spreadsheets into the database

### Generator data import
`php artisan import:gendata <file>` where `<file>` is the Excel spreadsheet containing the generator test data to import.  Use the full path when specifying `<file>`, e.g. `~/path/to/spreadsheet.xlsx`.

## Lookup table editing
Commands to edit the different lookup tables used.  The lookup tables are:
* location
* manufacturer
* modality
* tester
* testtype

### Listing lookup table entries
`php artisan lut:list <table>` where `<table>` is the lookup table to list (one of `location`, `manufacturer`, `modality`, `tester`, `testtype`)

### Adding entries to lookup tables
`php artisan lut:add <table> <value>` where <table> is the database table to add an entry to (one of `location`, `manufacturer`, `modality`, `tester`, `testtype`)

### Removing entries from lookup tables
`php artisan lut:delete <table> <value>` where <table> is the database table to add an entry to (one of `location`, `manufacturer`, `modality`, `tester`, `testtype`)

## Adding equipment
Commands used to add or edit equipment

### Adding a new machine
`php artisan machine:add` will add a new machine to the database.  After the machine has been added, user will be prompted to add a tube for the machine.

### Adding a new tube
`php artisan tube:add <machine_id>` where `<machine_id>` the machine ID that will be associated with the tube.  `<machine_id>` is optional and the user will be prompted for one if it is not given.

## Adding reports

### Adding survey reports
`php artisan surveyreport:add <survey_id> <report_file>` where `<survey_id>` is the survey ID number of the report and `<report_file>` is the name of the survey report (including path information) to be added.

## Adding surveys
`php artisan survey:add <machine_id>` where <machine_id> is the ID of the machine to add a survey for.  If <machine_id> isn't provided, the user will be prompted to search for a machine to add a survey for.
