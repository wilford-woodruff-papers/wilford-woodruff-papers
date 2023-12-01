<?php

beforeEach(function () {
    $this->topic = \App\Models\Subject::factory()
        ->topic()
        ->hasAttached(
            \App\Models\Category::factory()
                ->create([
                    'name' => 'Index',
                ]),
            relationship: 'category'
        )
        ->create([
            'name' => 'adoption',
            'index' => 'A',
            'tagged_count' => 1,
            'text_count' => 1,
            'total_usage_count' => 1,
        ]);
    $this->topic->load([
        'category',
    ]);
});

it('has topics page', function () {
    $this->get(route('topics'))
        ->assertStatus(200)
        ->assertSee($this->topic->name);
});
