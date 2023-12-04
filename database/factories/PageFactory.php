<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Page;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $item = Item::factory()->journal();

        return [
            'name' => $this->faker->name(),
            'ftp_id' => $this->faker->word(),
            'ftp_link' => $this->faker->word(),
            'transcript' => $this->faker->word(),
            'order' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'type_id' => Type::factory(),
            'imported_at' => Carbon::now(),
            'full_name' => $this->faker->name(),
            'transcript_link' => $this->faker->word(),
            'is_blank' => $this->faker->boolean(),
            'first_date' => Carbon::now(),
            'clear_text_transcript' => $this->faker->text(),

            'item_id' => $item,
            'parent_item_id' => $item,
        ];
    }
}
