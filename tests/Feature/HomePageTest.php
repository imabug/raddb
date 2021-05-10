<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_IndexPageLoadsViaHttp()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/');

        $response->assertStatus(200);
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
