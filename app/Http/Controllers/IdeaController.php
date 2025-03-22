<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CategoryEnum;
use App\Enums\LevelEnum;
use App\Models\Search;
use Inertia\Inertia;
use Inertia\Response;

final class IdeaController extends Controller
{
    /**
     * Display the main page.
     */
    public function __invoke(Search $search): Response
    {
        $ideas = [];

        return Inertia::render('Main', [
            'categories' => collect(CategoryEnum::toArrayWithLabels())
                ->map(fn ($label, $value) => ['value' => $value, 'label' => $label])
                ->values()
                ->all(),
            'levels' => collect(LevelEnum::toArrayWithLabels())
                ->map(fn ($label, $value) => ['value' => $value, 'label' => $label])
                ->values()
                ->all(),
            'ideas' => $ideas,
        ]);
    }
}
