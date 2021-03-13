<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
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
                ->has(
                    Item::factory()
                        ->count(3)
                )
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
        Artisan::call('import:family');

        Team::insert([
            ['name' => 'Board of Directors'],
            ['name' => 'Staff'],
            ['name' => 'Officers'],
            ['name' => 'Advisors'],
        ]);

        Artisan::call('import:team');

    }
}
