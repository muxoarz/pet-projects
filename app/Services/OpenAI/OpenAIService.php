<?php

declare(strict_types=1);

namespace App\Services\OpenAI;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use JsonException;
use OpenAI;
use OpenAI\Client;

final class OpenAIService
{
    private const int CACHE_HOURS_DURATION = 10;

    private Client $client;

    public function __construct(
        public OpenAIRequestsFactoryInterface $openAIRequestsFactory,
        private bool $useCache = true
    ) {
        /** @var string $apiKey */
        $apiKey = config('services.openai.api_key');
        $this->client = OpenAI::client($apiKey);
    }

    /**
     * Generate ideas in the Chatbot
     *
     * @return array<int, array{'title': string, 'description': string}>
     *
     * @throws JsonException
     */
    public function generateIdeas(
        string $category,
        string $level,
    ): array {
        $result = $this->request(
            $this->openAIRequestsFactory->getIdeasRequest($category, $level)
        );

        /** @var array<'topics', array<int, array<string, string>>> $topics */
        $topics = json_decode(json: $result, associative: true, flags: JSON_THROW_ON_ERROR);

        return collect($topics['topics'] ?? [])->map(
            static fn (array $idea) => ['title' => $idea['title'], 'description' => $idea['description']]
        )->all();
    }

    private function request(string $text, bool $json = true): string
    {
        $key = md5($text.($json ? '-json' : ''));

        if ($this->useCache && $cachedContent = Cache::get($key)) {
            Log::debug('OpenAI cached request: ', ['text' => $text, 'json' => $json]);

            // @phpstan-ignore-next-line
            return $cachedContent;
        }

        $timeStart = microtime(true);
        $result = $this->client->chat()->create([
            'model' => config('services.openai.model'),
            'messages' => [
                ['role' => 'user', 'content' => $text],
            ],
            ...($json ? ['response_format' => ['type' => 'json_object']] : []),
        ]);

        $content = $result->choices[0]->message->content ?? '';

        if ($this->useCache) {
            Cache::put($key, $content, now()->addHours(self::CACHE_HOURS_DURATION));
        }

        Log::debug('OpenAI request/response: ', [
            'text' => $text,
            'json' => $json,
            'result' => $content,
            'duration' => microtime(true) - $timeStart,
        ]);

        return $content;

    }
}
