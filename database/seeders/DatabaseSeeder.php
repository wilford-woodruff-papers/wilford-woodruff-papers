<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Photo;
use App\Models\Team;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory([
            'name' => 'Jon',
            'email' => 'jon.fackrell@wilfordwoodruffpapers.org',
        ])->create();

        foreach(['Autobiographies', 'Discourses', 'Journals', 'Letters'] as $type) {
            Type::factory([
                    'name' => $type,
                ])
                /*->has(
                    Item::factory()
                        ->count(3)
                )*/
                ->create();
        }

        Category::insert([
            ['name' => 'Apostle'],
            ['name' => 'British Convert'],
            ['name' => 'Business'],
            ['name' => 'Family'],
            ['name' => 'Host'],
            ['name' => 'People'],
            ['name' => 'Places'],
            ['name' => 'Topics'],
            ['name' => 'Scriptural Figures'],
            ['name' => 'Southern Converts'],
            ['name' => 'Topics'],
        ]);

        Artisan::call('import:subjects');
        Artisan::call('import:bios');
        Artisan::call('import:family');

        Team::insert([
            ['name' => 'Board of Directors'],
            ['name' => 'Staff'],
            ['name' => 'Officers'],
            ['name' => 'Advisors'],
        ]);

        Artisan::call('import:team');

        $photos = Photo::factory()
                        ->count(3)
                        ->create();

        foreach($photos as $photo){
            $photo->addMediaFromUrl('https://wilfordwoodruffpapers.org/files/medium/8ff5ef10524521faea83c55ac813b16251c0c992.jpg')->toMediaCollection();
        }

        Artisan::call('import:podcasts');
        Artisan::call('import:videos');
        Artisan::call('import:news');
        Artisan::call('import:items');

        $letter = Item::where('name', 'Letter to Phebe Whittemore Carter Woodruff, September 30, 1839')->first();
        $letter->type()->associate(Type::whereName('Letters')->first());
        $letter->save();
        $journal = Item::where('name', 'Journal (September 9, 1836–December 31, 1836)')->first();
        $journal->type()->associate(Type::whereName('Journals')->first());
        $journal->save();

        Item::whereIn('name', [
                    'Journal (September 9, 1836–December 31, 1836)',
                    'Letter to Phebe Whittemore Carter Woodruff, September 30, 1839',
                ])
                ->update(['enabled' => 1]);

        Artisan::call('import:pages');
    }
}
