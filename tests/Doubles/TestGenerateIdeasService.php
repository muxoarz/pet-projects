<?php

declare(strict_types=1);

namespace Tests\Doubles;

use App\DTOs\IdeaDTO;

final class TestGenerateIdeasService
{
    /** @var array<int, array<string, string>|IdeaDTO> $mockIdeas */
    private array $mockIdeas {
        set {
            $this->mockIdeas = $value;
        }
    }

    /**
     * @param array<int, array<string, string>|IdeaDTO> $mockIdeas
     */
    public function __construct(array $mockIdeas = [])
    {
        $this->mockIdeas = $mockIdeas;
    }

    /**
     * @return array<int, array<string, string>|IdeaDTO>
     */
    public function generateIdeas(string $category, string $level): array
    {
        return $this->mockIdeas;
    }

}
