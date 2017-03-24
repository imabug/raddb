<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TestAppDashboard extends TestCase
{
    /**
     * @test main index page
     *
     * @return void
     */
    public function testMainIndex()
    {
        $page = $this->get(route('index'));
        $page->assertStatus(200);
        $page->assertSee('Survey Schedule');
        $page->assertSee('Pending surveys');
        $page->assertSee('Surveys to be scheduled');
    }

    /**
     * @test survey status dashboard
     *
     * @return void
     */
    public function testSurveyStatus()
    {
        $page = $this->get(route('dashboard.dashboard'));
        $page->assertStatus(200);
        $page->assertSee('Equipment Testing Status Dashboard');
    }

    /**
     * @test surveys to be scheduled
     *
     * @return void
     */
    public function testToBeScheduled()
    {
        $page = $this->get(route('dashboard.showUntested'));
        $page->assertStatus(200);
        $page->assertSee('Surveys to be scheduled');
    }

    /**
     * @test pending surveys
     *
     * @return void
     */
    public function testPending()
    {
        $page = $this->get(route('dashboard.showPending'));
        $page->assertStatus(200);
        $page->assertSee('Pending surveys');
    }

    /**
     * @test survey schedule
     *
     * @return void
     */
    public function testSurveySchedule()
    {
        $page = $this->get(route('dashboard.showSchedule'));
        $page->assertStatus(200);
        $page->assertSee('Survey Schedule');
    }

    /**
     * @test survey graphs
     * @return void
     */
     public function testSurveyGraphs()
     {
         $page = $this->get(route('dashboard.surveyGraph'));
         $page->assertStatus(200);
         $page->assertSee('Survey Count Graphs');
     }
}
