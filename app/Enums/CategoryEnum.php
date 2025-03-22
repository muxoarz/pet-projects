<?php

declare(strict_types=1);

namespace App\Enums;

enum CategoryEnum: string
{
    case Web = 'web';
    case Mobile = 'mobile';
    case Desktop = 'desktop';
    case IoT = 'iot';
    case AI = 'ai';
    case ML = 'ml';
    case Game = 'game';

    /**
     * Returns an array with the keys and label of the enum.
     *
     * @return array<string, string>
     */
    public static function toArrayWithLabels(): array
    {
        return [
            self::Web->value => __('Web Development'),
            self::Mobile->value => __('Mobile Applications'),
            self::Desktop->value => __('Desktop'),
            self::IoT->value => __('IoT'),
            self::AI->value => __('Artificial Intelligence'),
            self::ML->value => __('Data Science & Machine Learning'),
            self::Game->value => __('Game Development'),
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
