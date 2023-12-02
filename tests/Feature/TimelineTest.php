<?php

it('has timeline page', function () {
    $response = $this->get('/timeline');

    $response->assertStatus(200);
});
