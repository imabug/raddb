<?php

use Laravel\Dusk\Browser;

it('has home page', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertSee('Radiological Equipment Database');
    });
});
// namespace Tests\Feature;

// use Tests\TestCase;

// class HomePageTest extends TestCase
// {
//     /**
//      * A basic feature test example.
//      *
//      * @return void
//      */
//     public function testIndexPageLoadsViaHttp()
//     {
//         $this->get('/')->assertStatus(200);
//     }

//     /**
//      * Test index route.
//      *
//      * @return void
//      */
//     public function testIndexRouteLoads()
//     {
//         $this->get(route('index'))->assertSee('Radiological Equipment Database');
//     }
// }
