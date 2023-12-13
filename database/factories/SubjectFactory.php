<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'name' => $this->faker->name(),
            'index' => $this->faker->word(),
            'bio' => $this->faker->word(),
            'footnotes' => $this->faker->word(),
            'enabled' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'redirect_to' => null,
            'tagged_count' => $this->faker->randomNumber(),
            'text_count' => $this->faker->randomNumber(),
            'total_usage_count' => $this->faker->randomNumber(),
            'hide_on_index' => $this->faker->boolean(),
            'search_in_text' => true,
            'unique_id' => null,
            'reference' => $this->faker->word(),
            'added_to_ftp_at' => Carbon::now(),
            'notes' => $this->faker->word(),
            'researcher_text' => null,
            'bio_completed_at' => Carbon::now(),
            'log_link' => $this->faker->word(),
            'skip_tagging' => false,
            'subject_id' => null,
            'researcher_id' => null,
        ];
    }

    public function person(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->name(),
                'last_name' => $this->faker->lastName(),
                'first_name' => $this->faker->firstName(),
                'middle_name' => $this->faker->name(),
                'suffix' => $this->faker->word(),
                'alternate_names' => $this->faker->word(),
                'maiden_name' => $this->faker->name(),
                'baptism_date' => $this->faker->word(),
                'subcategory' => null,
                'pid_identified_at' => Carbon::now(),
                'bio_approved_at' => Carbon::now(),
                'relationship' => $this->faker->word(),
                'birth_date' => $this->faker->word(),
                'death_date' => $this->faker->word(),
                'life_years' => $this->faker->word(),
                'pid' => $this->faker->word(),
            ];
        });
    }

    public function place(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->city(),
                'address' => $this->faker->address(),
                'latitude' => $this->faker->latitude(),
                'longitude' => $this->faker->longitude(),
                'geolocation' => $this->faker->words(),
                'country' => $this->faker->country(),
                'state_province' => $this->faker->city(),
                'county' => $this->faker->country(),
                'city' => $this->faker->city(),
                'specific_place' => $this->faker->streetName(),
                'years' => null,
                'modern_location' => null,
                'visited' => $this->faker->boolean(),
                'mentioned' => $this->faker->boolean(),
                'place_confirmed_at' => Carbon::now(),
            ];
        });
    }

    public function topic(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->word(),
            ];
        });
    }
}
