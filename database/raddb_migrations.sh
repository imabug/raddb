#!/bin/sh

# Database migrations

php artisan make:migration create_contacts_table --create=contacts
php artisan make:migration create_gendata_table --create=gendata
php artisan make:migration create_locations_table --create=locations
php artisan make:migration create_machines_table --create=machines
php artisan make:migration create_manufacturers_table --create=manufacturers
php artisan make:migration create_modalities_table --create=modalities
php artisan make:migration create_opnotes_table --create=opnotes
php artisan make:migration create_recommendations_table --create=recommendations
php artisan make:migration create_testdates_table --create=testdates
php artisan make:migration create_testers_table --create=testers
php artisan make:migration create_testtypes_table --create=testtypes
php artisan make:migration create_tubes_table --create=tubes
php artisan make:migration add_fk

# Models

php artisan make:model Contact
php artisan make:model GenData
php artisan make:model Location
php artisan make:model Machine
php artisan make:model Manufacturer
php artisan make:model Modality
php artisan make:model OpNote
php artisan make:model Recommendation
php artisan make:model TestDate
php artisan make:model Tester
php artisan make:model TestType
php artisan make:model Tube

# Controllers
php artisan make:controller MachineController --resource
php artisan make:controller ContactController --resource
php artisan make:controller TubeController --resource
php artisan make:controller GenDataController --resource
php artisan make:controller OpNoteController --resource
php artisan make:controller RecommendationController --resource
php artisan make:controller TestDateController --resource

