<?php

declare(strict_types=1);

namespace App\DTOs;

final readonly class IdeaDto
{
    public function __construct(
        public string $title,
        public string $description,
    ) {}
}
