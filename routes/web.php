<?php

declare(strict_types=1);

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\MainPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainPageController::class)->name('main');
Route::get('/idea/{idea:hash}', IdeaController::class)->name('idea');

require __DIR__.'/auth.php';
