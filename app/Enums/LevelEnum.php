<?php

declare(strict_types=1);

namespace App\Enums;

enum LevelEnum: string
{
    case Easy = 'easy';
    case Moderate = 'moderate';
    case Difficult = 'difficult';

    /**
     * Returns an array with the keys and label of the enum.
     *
     * @return array<string, string>
     */
    public static function toArrayWithLabels(): array
    {
        return [
            self::Easy->value => __('Easy'),
            self::Moderate->value => __('Moderate'),
            self::Difficult->value => __('Difficult'),
        ];
    }

    /**
     * Returns the label for the given key.
     */
    public static function getLabelByKey(string $key): string
    {
        return self::toArrayWithLabels()[$key];
    }
}
