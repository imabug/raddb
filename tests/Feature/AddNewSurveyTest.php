<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddNewSurveyTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * See if the add new survey form loads properly.
     *
     * @return void
     */
    public function testAddNewSurveyFormLoadsProperly()
    {
        $page = $this->get(route('surveys.create'));
        $page->assertStatus(200);
    }
}
