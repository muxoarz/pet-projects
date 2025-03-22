<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\IdeaDTO;
use App\Services\OpenAI\OpenAIEnRequestsFactory;
use App\Services\OpenAI\OpenAIService;
use Illuminate\Support\Arr;
use JsonException;

final class GenerateIdeasService
{
    /**
     * @return array<int, IdeaDTO>
     *
     * @throws JsonException
     */
    public function generateIdeas(string $category, string $level): array
    {
        $langFactory = app(OpenAIEnRequestsFactory::class);
        /** @var OpenAIService $openAISvc */
        $openAISvc = app(OpenAIService::class, ['openAIRequestsFactory' => $langFactory]);

        $ideas = $openAISvc->generateIdeas($category, $level);

        // @phpstan-ignore-next-line
        return Arr::map($ideas, static fn (array $idea) => new IdeaDTO(title: $idea['title'], description: $idea['description']));
    }
}
