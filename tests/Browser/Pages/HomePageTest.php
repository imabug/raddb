<?php

use Larave\Dusk\Browser;

it('has homepage', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')->assertSee('Radiological Equipment Database');
    });
});
