<?php

namespace Tests\Unit;

use Tests\TestCase;
use RadDB\Location;
use Illuminate\Foundation\Testing\WithoutMiddleware;

// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends TestCase
{
    public function setup()
    {
        $this->location = new Location;
    }

    /**
     * Test to see if the location index page can be loaded
     *
     * @return void
     */
    public function testLocationIndexPage()
    {
        $response = $this->get('/admin/locations');
        $response->assertStatus(200);

        $response = $this->visit('/admin/locations')
             ->see('Locations');
    }
}
