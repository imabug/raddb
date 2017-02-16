# Radiology Equipment DB

Radiology imaging equipment management system to track equipment inventory and annual testing of radiology imaging equipment.

This application will track

* radiology imaging equipment inventory
* surveys performed on imaging equipment for
  * acceptance testing
  * annual surveys
  * surveys following major repairs
  * shielding surveys
* report repository
* survey recommendations
* test equipment used for performing surveys
  * required calibrations on test equipment

## Install

* Clone the Github repository for the [project](https://github.com/imabug/raddb)
* Run ```composer install``` to install the Laravel framework and associated software bits
* Edit ```.env.example``` and customize database server section for local settings. Save as ```.env```
* Run ```php artisan key:generate``` to generate an application key
* For testing purposes, run ```php artisan serve``` and point your web browser at ```http://localhost:8000```
* For production, configure a web server virtual host using the ```public``` directory as the DocumentRoot

This project is developed in PHP using the [Laravel framework](https://laravel.com/).

[![StyleCI](https://styleci.io/repos/66408419/shield?branch=master)](https://styleci.io/repos/66408419)
