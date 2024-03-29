<?php

test('Survey status page exists', function () {
    $response = $this->get('/dashboard')
        ->assertStatus(200);
});

test('Survey graph page exists', function () {
    $response = $this->get('/dashboard/surveyCount')
        ->assertStatus(200);
});

test('Survey calendar page exists', function () {
    $response = $this->get('/dashboard/surveyCalendar')
        ->assertStatus(200);
});

test('Survey categories page exists', function () {
    $response = $this->get('/dashboard/surveyCategories')
        ->assertStatus(200);
});
// namespace Tests\Feature;

// use Tests\TestCase;

// class DashboardPagesTest extends TestCase
// {
//     /**
//      * Test to see if the dashboard pages load via HTTP requests.
//      *
//      * @dataProvider dashboardPages
//      *
//      * @return void
//      */
//     public function testDashboardPagesLoadViaHttp($pageName, $value)
//     {
//         $this->get($pageName)->assertStatus(200);
//     }

//     public function dashboardPages(): array
//     {
//         return [
//             'Survey status'           => ['/dashboard', 'Equipment Testing Status Dashboard'],
//             'Survey graphs'           => ['dashboard/surveyCount', 'Survey graphs'],
//         ];
//     }
// }
