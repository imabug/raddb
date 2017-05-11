<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ListingsTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test to see that the Listings pages load.
     * @dataProvider listingPages
     * @return void
     */
    public function testListingPagesLoadProperly($routeName, $value)
    {
        $this->get(route($routeName))->assertSee($value);
    }

    public function listingPages()
    {
        return [
            ['machines.index', 'Equipment Inventory - Active'],
            ['machines.showModalityIndex', 'List equipment by modality'],
            ['machines.showLocationIndex', 'List equipment by location'],
            ['machines.showManufacturerIndex', 'List equipment by manufacturer'],
            ['machines.inactive', 'Equipment Inventory - Inactive'],
            ['machines.removed', 'Equipment Inventory - Removed'],
            ['testequipment.index', 'Equipment Inventory - Test Equipment'],
            ['testequipment.showCalDates', 'Recent Test Equipment Calibration Dates'],
        ];
    }
}
