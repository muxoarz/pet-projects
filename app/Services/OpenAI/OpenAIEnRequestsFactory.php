<?php

declare(strict_types=1);

namespace App\Services\OpenAI;

use App\Enums\CategoryEnum;
use App\Enums\LevelEnum;

final class OpenAIEnRequestsFactory implements OpenAIRequestsFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getIdeasRequest(string $category, string $level): string
    {
        return 'Suggest topics for programming the Pet project in the category "'
            .__(CategoryEnum::getLabelByKey($category))
            .'" and expected difficulty level "'
            .__(LevelEnum::getLabelByKey($level))
            .'". Return list in JSON format in the field named "topics".';
    }
}
