<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'order' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'background_color' => $this->faker->hexColor(),
            'text_color' => $this->faker->hexColor(),
            'expanded' => $this->faker->boolean(),
        ];
    }
}
