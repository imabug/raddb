<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AdminTest extends TestCase
{
    /**
     * Test to see that the admin pages can be loaded.
     * @dataProvider adminPages
     *
     * @return void
     */
    public function testAdminPagesLoadProperly($routeName, $value)
    {
        $this->withoutMiddleware()->get(route($routeName))->assertSee($value);
    }

    public function adminPages()
    {
        return [
            ['locations.index', 'Locations'],
            ['manufacturers.index', 'Manufacturers'],
            ['modalities.index', 'Modalities'],
            ['testers.index', 'Testers'],
            ['testtypes.index', 'Test Types'],
        ];
    }
}
