<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CategoryEnum;
use App\Enums\LevelEnum;
use App\Http\Requests\GenerateRequest;
use App\Services\GenerateIdeasService;
use Inertia\Inertia;
use Inertia\Response;

final class MainPageController extends Controller {
    /**
     * Display the main page.
     */
    public function __invoke(GenerateRequest $request): Response
    {
        $ideas = [];
        $category = $request->enum('category', CategoryEnum::class);
        $level = $request->enum('level', LevelEnum::class);

        if ($category && $level) {
            /** @var GenerateIdeasService $ideasSvc */
            $ideasSvc = app(GenerateIdeasService::class);

            $ideas = $ideasSvc->generateIdeas($category->value, $level->value);
        }

        return Inertia::render('Main', [
            'category' => $category?->value,
            'level' => $level?->value,
            'categories' => collect(CategoryEnum::toArrayWithLabels())
                ->map(fn($label, $value) => ['value' => $value, 'label' => $label])
                ->values()
                ->all(),
            'levels' => collect(LevelEnum::toArrayWithLabels())
                ->map(fn($label, $value) => ['value' => $value, 'label' => $label])
                ->values()
                ->all(),
            'ideas' => $ideas,
        ]);
    }
}
