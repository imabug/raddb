<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexPageLoadsViaHttp()
    {
        $this->get('/')->assertStatus(200);
    }

    /**
     * Test index route
     * @return void
     */
    public function testIndexRouteLoads()
    {
        $this->get(route('index'))->assertSee("Radiological Equipment Database");
    }
}
