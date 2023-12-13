<?php

namespace Database\Factories;

use App\Models\BoardMember;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BoardMemberFactory extends Factory
{
    protected $model = BoardMember::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'title' => $this->faker->word(),
            'image' => $this->faker->word(),
            'bio' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'video_link' => $this->faker->word(),
            'supporting_image' => $this->faker->word(),
            'supporting_image_description' => $this->faker->words(12, true),
            'supporting_person_name' => $this->faker->name(),
            'supporting_person_link' => $this->faker->word(),
            'team_id' => null,
        ];
    }
}
