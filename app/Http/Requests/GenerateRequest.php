<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\CategoryEnum;
use App\Enums\LevelEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GenerateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['sometimes', Rule::enum(CategoryEnum::class)],
            'level' => ['sometimes', Rule::enum(LevelEnum::class)],
        ];
    }
}
