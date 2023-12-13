<?php

namespace Database\Factories;

use App\Models\JobOpportunity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class JobOpportunityFactory extends Factory
{
    protected $model = JobOpportunity::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'summary' => $this->faker->text(),
            'description' => $this->faker->text(),
            'file' => $this->faker->word(),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
