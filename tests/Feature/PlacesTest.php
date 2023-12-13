<?php

beforeEach(function () {
    $this->place = \App\Models\Subject::factory()
        ->place()
        ->hasAttached(
            \App\Models\Category::factory()
                ->create([
                    'name' => 'Places',
                ]),
            relationship: 'category'
        )
        ->create([
            'name' => 'Amity, Apache County, Arizona Territory',
            'index' => 'A',
            'tagged_count' => 1,
            'text_count' => 1,
            'total_usage_count' => 1,
            'state_province' => 'Arizona Territory',
            'county' => 'Apache County',
            'city' => 'Amity',
        ]);
    $this->place->load([
        'category',
    ]);
});

it('has places page', function () {
    $this->get(route('places'))
        ->assertStatus(200)
        ->assertSee($this->place->display_name);
});
