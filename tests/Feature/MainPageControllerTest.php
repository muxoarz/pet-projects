<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DTOs\IdeaDTO;
use App\Enums\CategoryEnum;
use App\Enums\LevelEnum;
use App\Services\GenerateIdeasService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\Doubles\TestGenerateIdeasService;
use Tests\TestCase;

final class MainPageControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Set a fake API key for OpenAI
        Config::set('services.openai.api_key', 'test-api-key');
        Config::set('services.openai.model', 'gpt-3.5-turbo');
    }

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
        // Create a test implementation
        $testService = new TestGenerateIdeasService();

        // Bind the test implementation
        App::instance(GenerateIdeasService::class, $testService);

        $category = CategoryEnum::cases()[0]->value;
        $level = LevelEnum::cases()[0]->value;

        $response = $this->get("/?category={$category}&level={$level}");

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Main')
            ->where('category', $category)
            ->where('level', $level)
            ->where('ideas', [])
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
        // Create mock ideas
        $mockIdeas = [
            new IdeaDTO(title: 'Test Idea 1', description: 'Description 1'),
            new IdeaDTO(title: 'Test Idea 2', description: 'Description 2'),
        ];

        // Create a test implementation
        $testService = new TestGenerateIdeasService($mockIdeas);

        // Bind the test implementation
        App::instance(GenerateIdeasService::class, $testService);

        $category = CategoryEnum::cases()[0]->value;
        $level = LevelEnum::cases()[0]->value;

        $response = $this->get("/?category={$category}&level={$level}");

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->has('ideas', count($mockIdeas))
        );
    }

    public function test_categories_are_properly_formatted(): void
    {
        $response = $this->get('/');
        $categories = CategoryEnum::toArrayWithLabels();

        // Get the first category using the proper method
        $categoriesArray = collect(CategoryEnum::toArrayWithLabels())
            ->map(fn ($label, $value) => ['value' => $value, 'label' => $label])
            ->values()
            ->all();

        $response->assertInertia(fn (Assert $page) => $page
            ->has('categories', count($categories))
            ->where('categories.0.value', $categoriesArray[0]['value'])
            ->where('categories.0.label', $categoriesArray[0]['label'])
        );
    }

    public function test_levels_are_properly_formatted(): void
    {
        $response = $this->get('/');
        $levels = LevelEnum::toArrayWithLabels();

        // Get the first level using the proper method
        $levelsArray = collect(LevelEnum::toArrayWithLabels())
            ->map(fn ($label, $value) => ['value' => $value, 'label' => $label])
            ->values()
            ->all();

        $response->assertInertia(fn (Assert $page) => $page
            ->has('levels', count($levels))
            ->where('levels.0.value', $levelsArray[0]['value'])
            ->where('levels.0.label', $levelsArray[0]['label'])
        );
    }
}
