<?php

beforeEach(function () {
    $types = \App\Models\Type::factory()
        ->count(9)
        ->sequence(
            ['name' => 'Autobiography Sections'],
            ['name' => 'Discourses'],
            ['name' => 'Journal Sections'],
            ['name' => 'Letters'],
            ['name' => 'Journals'],
            ['name' => 'Autobiographies'],
            ['name' => 'Additional'],
            ['name' => 'Daybooks'],
            ['name' => 'Additional Sections'],
        )
        ->create();
    $journal = $types->where('name', 'Journals')->first();
    $journalSections = $types->where('name', 'Journal Sections')->first();
    $journalSections->type_id = $journal->id;
    $journalSections->save();
});

it('has dayinthelife page', function () {
    \App\Models\Date::factory()
        ->create([
            'date' => '1830-12-07',
            'dateable_id' => \App\Models\Page::factory()
                ->create([
                    'name' => 'Day in the Life',
                    'type_id' => 5,
                ])
                ->id,
        ]);

    $response = $this->get('/day-in-the-life/1830-12-07');

    $response->assertStatus(200);
});
