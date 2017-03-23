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
        $this->get(route('index'))->assertStatus(200);
    }

    /**
     * @test survey status dashboard
     *
     * @return void
     */
    public function testSurveyStatus()
    {
        $this->get(route('dashboard.dashboard'))->assertStatus(200);
    }

    /**
     * @test surveys to be scheduled
     *
     * @return void
     */
    public function testToBeScheduled()
    {
        $this->get(route('dashboard.showUntested'))->assertStatus(200);
    }

    /**
     * @test pending surveys
     *
     * @return void
     */
    public function testPending()
    {
        $this->get(route('dashboard.showPending'))->assertStatus(200);
    }

    /**
     * @test survey schedule
     *
     * @return void
     */
    public function testSurveySchedule()
    {
        $this->get(route('dashboard.showSchedule'))->assertStatus(200);
    }

    /**
     * @test survey graphs
     * @return void
     */
     public function testSurveyGraphs()
     {
         $this->get(route('dashboard.surveyGraph'))->assertStatus(200);
     }
}
