<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddNewSurveyRecommendationTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * See if the Add new recommendations form loads.
     *
     * @return void
     */
    public function testNewRecommendationFormLoadsProperly()
    {
        $page = $this->get(route('recommendations.create'));
        $page->assertStatus(200);
    }
}
