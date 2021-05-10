<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardPagesTest extends TestCase
{
    /**
     * Test to see that the dashboard routes load
     *
     * @dataProvider dashboardRoutes
     * @return void
     */
    public function test_DashboardPagesLoadProperly($routeName, $value)
    {
        $this->get(route($routeName))->assertSee($value);
    }

    public function dashboardRoutes(): array
    {
        return [
            'Survey status' => ['dashboard.dashboard', 'Equipment Testing Status Dashboard'],
            'Surveys to be scheduled' => ['dashboard.showUntested', 'Surveys to be scheduled'],
            'Pending survey' => ['dashboard.showPending', 'Pending surveys'],
            'Survey schedule' => ['dashboard.showSchedule', 'Survey Schedule'],
        ];
    }

    /**
     * Test to see if the dashboard pages load via HTTP requests
     *
     * @dataProvider dashboardPages
     * @return void
     */
    public function test_DashboardPagesLoadViaHttp($pageName, $value)
    {
        $this->get($pageName)->assertStatus(200);
    }

    public function dashboardPages(): array
    {
        return [
            'Survey status' => ['/dashboard', 'Equipment Testing Status Dashboard'],
            'Surveys to be scheduled' => ['/dashboard/showUntested', 'Surveys to be scheduled'],
            'Pending survey' => ['/dashboard/showPending', 'Pending surveys'],
            'Survey schedule' => ['/dashboard/showSchedule', 'Survey Schedule'],
        ];
    }
}
