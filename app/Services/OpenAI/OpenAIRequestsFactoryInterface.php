<?php

declare(strict_types=1);

namespace App\Services\OpenAI;

interface OpenAIRequestsFactoryInterface
{
    /**
     * Get ideas request
     */
    public function getIdeasRequest(string $category, string $level): string;
}
