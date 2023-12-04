<?php

namespace Database\Factories;

use App\Models\Date;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class DateFactory extends Factory
{
    protected $model = Date::class;

    public function definition(): array
    {
        return [
            'date' => '1830-12-07',
            'dateable_id' => Page::factory(),
            'dateable_type' => Page::class,
        ];
    }
}
