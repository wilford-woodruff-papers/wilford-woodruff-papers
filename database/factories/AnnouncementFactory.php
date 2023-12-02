<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'image' => $this->faker->word(),
            'start_publishing_at' => Carbon::now()->subWeek(),
            'end_publishing_at' => Carbon::now()->addWeek(),
            'link' => $this->faker->word(),
            'button_text' => $this->faker->text(),
            'button_link' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'type' => 'homepage_top',
            'slug' => $this->faker->slug(),
        ];
    }
}
