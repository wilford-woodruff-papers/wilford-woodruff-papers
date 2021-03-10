<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

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

    }
}
