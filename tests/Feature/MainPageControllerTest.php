<?php

namespace Tests\Feature;

use App\Enums\CategoryEnum;
use App\Enums\LevelEnum;
use App\Services\GenerateIdeasService;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia as Assert;
use Mockery;
use Tests\TestCase;

class MainPageControllerTest extends TestCase
{
    public function test_main_page_can_be_rendered_without_parameters(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Main')
            ->where('category', null)
            ->where('level', null)
            ->has('categories')
            ->has('levels')
            ->where('ideas', [])
        );
    }

    public function test_main_page_accepts_valid_parameters(): void
    {
        Http::fake();

        $category = CategoryEnum::cases()[0]->value;
        $level = LevelEnum::cases()[0]->value;

        $response = $this->get("/?category={$category}&level={$level}");

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Main')
            ->where('category', $category)
            ->where('level', $level)
        );
    }

    public function test_main_page_handles_invalid_parameters(): void
    {
        $response = $this->get('/?category=invalid&level=invalid');

        $response->assertStatus(302); // Redirects due to validation failure
        $response->assertSessionHasErrors(['category', 'level']);
    }

    public function test_ideas_are_generated_when_both_parameters_provided(): void
    {
        $category = CategoryEnum::cases()[0]->value;
        $level = LevelEnum::cases()[0]->value;
        $mockIdeas = ['Idea 1', 'Idea 2'];

        // Create a partial mock of GenerateIdeasService
        $mockService = Mockery::mock(app(GenerateIdeasService::class))->makePartial();
        $mockService->expects('generateIdeas')
            ->with($category, $level)
            ->andReturns($mockIdeas);
        $this->app->instance(GenerateIdeasService::class, $mockService);

        $response = $this->get("/?category={$category}&level={$level}");

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->where('ideas', $mockIdeas)
        );
    }

    public function test_categories_are_properly_formatted(): void
    {
        $response = $this->get('/');
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
        $response = $this->get('/');
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
