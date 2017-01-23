<?php


class TestAppDashboard extends TestCase
{
    /**
     * @test main index page
     *
     * @return void
     */
    public function testMainIndex()
    {
        $this->visit('index');
    }

    /**
     * @test survey status dashboard
     *
     * @return void
     */
    public function testSurveyStatus()
    {
        $this->visit('dashboard.dashboard');
    }

    /**
     * @test surveys to be scheduled
     *
     * @return void
     */
    public function testToBeScheduled()
    {
        $this->visit('dashbaord.showUntested');
    }

    /**
     * @test pending surveys
     *
     * @return void
     */
    public function testPending()
    {
        $this->visit('dashboard.showPending');
    }

    /**
     * @test survey schedule
     *
     * @return void
     */
    public function testSurveySchedule()
    {
        $this->visit('dashboard.showSchedule');
    }
}
