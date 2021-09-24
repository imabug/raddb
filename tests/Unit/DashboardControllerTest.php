<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIndexViewIsRendered()
    {
        $this->view('index')->assertSee('Radiological Equipment Database');
        $this->view('index')->assertSee('Survey Schedule');
    }
}
