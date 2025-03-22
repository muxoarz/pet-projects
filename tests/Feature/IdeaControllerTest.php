<?php

namespace Tests\Feature;

use App\Enums\CategoryEnum;
use App\Enums\LevelEnum;
use App\Models\Search;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IdeaControllerTest extends TestCase
{
    public function test_main_page_can_be_rendered(): void
    {
        $response = $this->get(route('main'));

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Main')
            ->has('categories')
            ->has('levels')
            ->where('ideas', [])
        );
    }

    public function test_categories_are_properly_formatted(): void
    {
        $response = $this->get(route('main'));
        $categories = CategoryEnum::toArrayWithLabels();
        $firstCategory = array_key_first($categories);

        $response->assertInertia(fn (Assert $page) => $page
            ->has('categories', count($categories))
            ->where('categories.0', [
                'value' => $firstCategory,
                'label' => $categories[$firstCategory]
            ])
        );
    }

    public function test_levels_are_properly_formatted(): void
    {
        $response = $this->get(route('main'));
        $levels = LevelEnum::toArrayWithLabels();
        $firstLevel = array_key_first($levels);

        $response->assertInertia(fn (Assert $page) => $page
            ->has('levels', count($levels))
            ->where('levels.0', [
                'value' => $firstLevel,
                'label' => $levels[$firstLevel]
            ])
        );
    }
}
