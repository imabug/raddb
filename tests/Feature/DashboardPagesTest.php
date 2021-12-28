<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardPagesTest extends TestCase
{
    /**
     * Test to see if the dashboard pages load via HTTP requests.
     *
     * @dataProvider dashboardPages
     *
     * @return void
     */
    public function testDashboardPagesLoadViaHttp($pageName, $value)
    {
        $this->get($pageName)->assertStatus(200);
    }

    public function dashboardPages(): array
    {
        return [
            'Survey status'           => ['/dashboard', 'Equipment Testing Status Dashboard'],
            'Survey graphs'           => ['dashboard/surveyCount', 'Survey graphs'],
        ];
    }
}
