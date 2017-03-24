<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class NewMachineTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * See if the new machine form loads properly.
     *
     * @return void
     */
    public function testNewMachineFormPageLoadsProperly()
    {
        $page = $this->get(route('machines.create'));
        $page->assertStatus(200);
    }
}
