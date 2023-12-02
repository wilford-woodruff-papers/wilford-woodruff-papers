<?php

beforeEach(function () {
    $this->person = \App\Models\Subject::factory()
        ->person()
        ->hasAttached(
            \App\Models\Category::factory()
                ->create([
                    'name' => 'People',
                ]),
            relationship: 'category'
        )
        ->create([
            'name' => 'Louisa Isabel Pray Adams',
            'index' => 'A',
            'first_name' => 'Louisa',
            'middle_name' => 'Isabel',
            'maiden_name' => 'Pray',
            'last_name' => 'Adams',
            'tagged_count' => 1,
            'text_count' => 1,
            'total_usage_count' => 1,
            'pid' => 'KNS5-9M9',
        ]);
    $this->person->load([
        'category',
    ]);
});

it('has people page', function () {
    $this->get(route('people'))
        ->assertStatus(200)
        ->assertSee($this->person->display_name);
});
