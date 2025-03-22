<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SearchItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SearchItem>
 */
final class SearchItemFactory extends Factory
{
    protected $model = SearchItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'search_id' => \App\Models\Search::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }
}
