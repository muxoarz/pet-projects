<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\CategoryEnum;
use App\Enums\LevelEnum;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class IdeaControllerTest extends TestCase
{
    #[Test]
    public function main_page_can_be_rendered(): void
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

    #[Test]
    public function categories_are_properly_formatted(): void
    {
        $response = $this->get(route('main'));
        $categories = CategoryEnum::toArrayWithLabels();
        $firstCategory = array_key_first($categories);

        $response->assertInertia(fn (Assert $page) => $page
            ->has('categories', count($categories))
            ->where('categories.0', [
                'value' => $firstCategory,
                'label' => $categories[$firstCategory],
            ])
        );
    }

    #[Test]
    public function levels_are_properly_formatted(): void
    {
        $response = $this->get(route('main'));
        $levels = LevelEnum::toArrayWithLabels();
        $firstLevel = array_key_first($levels);

        $response->assertInertia(fn (Assert $page) => $page
            ->has('levels', count($levels))
            ->where('levels.0', [
                'value' => $firstLevel,
                'label' => $levels[$firstLevel],
            ])
        );
    }
}
