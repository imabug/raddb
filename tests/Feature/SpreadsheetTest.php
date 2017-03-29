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
    // public function testLoadingXlsSpreadsheetFile()
    // {
    //     $page = $this->get(route('test.loadXlsSpreadsheet'));
    //     $page->assertStatus(200);
    //
    // }

    public function testLoadingOdsSpreadsheetFile()
    {
        $page = $this->get(route('test.loadOdsSpreadsheet'));
        $page->assertStatus(200);
        $page->assertSee('Fluoro');
    }
}
