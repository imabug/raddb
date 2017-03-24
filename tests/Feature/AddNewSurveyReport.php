<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddNewSurveyReport extends TestCase
{
    use WithoutMiddleware;

    /**
     * See if the Add survey report form loads properly.
     *
     * @return void
     */
    public function testAddSurveyReportFormLoadsProperly()
    {
        $page = $this->get(route('surveyreports.create'));
        $page->assertStatus(200);
    }
}
