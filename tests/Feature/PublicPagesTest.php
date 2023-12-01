<?php

it('can access public pages', function () {
    $announcements = \App\Models\Announcement::factory()
        ->count(3)
        ->create();

    $this->get('/')
        ->assertStatus(200)
        ->assertSee(str()->limit($announcements[0]->title, 25, ''));

    $this->get(route('donate'))
        ->assertStatus(200)
        ->assertSee('Give Online');

    $this->get(route('donate'))
        ->assertStatus(200)
        ->assertSee('Give Online');
});
