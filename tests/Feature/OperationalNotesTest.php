<?php

it('has operational notes page', function () {
    $response = $this->get('/opnotes/opnotes');

    $response->assertStatus(200);
});
