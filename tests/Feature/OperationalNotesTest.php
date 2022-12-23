<?php

use function Pest\Laravel\get;

it('has create operational notes page', function ($url) {
    get($url)->assertStatus(302);
})->with([
    'Without a machine' => '/opnotes/create',
    'With a machine' => '/opnotes/233/create',
]);
