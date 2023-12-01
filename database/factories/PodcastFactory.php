<?php

namespace Database\Factories;

use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PodcastFactory extends Factory
{
    protected $model = Podcast::class;

    public function definition(): array
    {
        return [
            'type' => Podcast::class,
            'title' => $this->faker->word(),
            'subtitle' => $this->faker->word(),
            'description' => $this->faker->text(),
            'date' => Carbon::now(),
            'link' => $this->faker->word(),
            'embed' => $this->faker->word(),
            'transcript' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'excerpt' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'cover_image' => $this->faker->word(),
            'publisher' => $this->faker->word(),
            'total_likes' => $this->faker->randomNumber(),
            'total_comments' => $this->faker->randomNumber(),
            'last_liked_at' => Carbon::now(),
            'external_link_only' => $this->faker->boolean(),
            'social_id' => $this->faker->word(),
            'social_type' => $this->faker->word(),
            'credits' => $this->faker->word(),
            'footnotes' => $this->faker->word(),
        ];
    }
}
