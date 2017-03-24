<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AddOpNoteTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * See if the add op note form loads properly.
     *
     * @return void
     */
    public function testAddOpNoteFormLoadsProperly()
    {
        $page = $this->get(route('opnotes.create'));
        $page->assertStatus(200);
    }
}