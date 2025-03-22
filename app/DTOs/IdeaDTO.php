<?php

declare(strict_types=1);

namespace App\DTOs;

final class IdeaDTO
{
    public function __construct(
        public string $title,
        public string $description,
    ) {}
}
