<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    /**
     * Test to see that the admin pages can be loaded
     * @dataProvider adminPages
     *
     * @return void
     */
    public function testAdminPages($uri, $value)
    {
        $this->withoutMiddleware()->get($uri)->assertSee($value);
    }

    public function adminPages()
    {
        return [
            ['/admin/locations', 'Locations'],
            ['/admin/manufacturers', 'Manufacturers'],
            ['/admin/modalities', 'Modalities'],
            ['/admin/testers', 'Testers'],
            ['/admin/testtypes', 'Test Types'],
        ];
    }
}
