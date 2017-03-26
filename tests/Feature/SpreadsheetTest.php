<?php

namespace Tests\Feature;

use Tests\TestCase;

class SpreadsheetTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoadingSpreadsheetFile()
    {
        $page = $this->get(route('test.loadSpreadsheet'));
        $page->assertStatus(200);
    }
}
