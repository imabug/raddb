<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListingsTest extends TestCase
{

    /**
     * Test to see that the Listings pages load.
     *
     * @dataProvider listingRoutes
     * @return void
     */
    public function testListingRoutesLoadProperly($routeName, $value)
    {
        $this->get(route($routeName))->assertSee($value);
    }

    public function listingRoutes()
    {
        return [
            'Machines listing' => ['machines.index', 'Equipment Inventory - Active'],
            'Modality listing' => ['machines.showModalityIndex', 'List equipment by modality'],
            'Location listing' => ['machines.showLocationIndex', 'List equipment by location'],
            'Manufacturer listing' => ['machines.showManufacturerIndex', 'List equipment by manufacturer'],
            'Inactive machines listing' => ['machines.inactive', 'Equipment Inventory - Inactive'],
            'Removed machines listing' => ['machines.removed', 'Equipment Inventory - Removed'],
            'Test equipment listing' => ['testequipment.index', 'Equipment Inventory - Test Equipment'],
            'Test equipment cal dates listing' => ['testequipment.showCalDates', 'Recent Test Equipment Calibration Dates'],
        ];
    }

    /**
     * Test that the Listings pages load via HTTP requests
     *
     * @dataProvider ListingPages
     * @return void
     **/
    public function testListingPagesLoadViaHttp($pageName, $value)
    {
        $this->get($pageName)->assertStatus(200);
    }

    public function listingPages(): array
    {
        return [
            'Machines listing' => ['/machines', 'Equipment Inventory - Active'],
            'Modality listing' => ['/machines/modalities', 'List equipment by modality'],
            'Location listing' => ['/machines/locations', 'List equipment by location'],
            'Manufacturer listing' => ['/machines/manufacturers', 'List equipment by manufacturer'],
            'Inactive machines listing' => ['/machines/inactive', 'Equipment Inventory - Inactive'],
            'Removed machines listing' => ['/machines/removed', 'Equipment Inventory - Removed'],
            'Test equipment listing' => ['/testequipment', 'Equipment Inventory - Test Equipment'],
            'Test equipment cal dates listing' => ['/testequipment/caldates', 'Recent Test Equipment Calibration Dates'],
        ];
    }
}
