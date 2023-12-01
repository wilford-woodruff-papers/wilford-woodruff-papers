<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
        ];
    }

    public function published(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'enabled' => true,
            ];
        });
    }

    public function notPublished(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'enabled' => false,
            ];
        });
    }
}
