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

it('can visit document browsing page', function () {
    $publishedItem = \App\Models\Item::factory()
        ->published()
        ->create([
            'type_id' => \App\Models\Type::query()
                ->where('name', 'Journals')
                ->first()
                ->id,
        ]);
    $unPublishedItem = \App\Models\Item::factory()
        ->notPublished()
        ->create([
            'type_id' => \App\Models\Type::query()
                ->where('name', 'Journals')
                ->first()
                ->id,
        ]);
    $this->get(route('documents'))
        ->assertStatus(200)
        ->assertSee('Journals')
        ->assertDontSee('Journal Sections')
        ->assertSee($publishedItem->name)
        ->assertDontSee($unPublishedItem->name);
});
