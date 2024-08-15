<?php

namespace App\Enums;

enum GenderEnum: int
{
    case male = 1;
    case female = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::male => __('genders.male'),
            self::female => __('genders.female'),
        };
    }

    public static function getEnum(string $string): ?GenderEnum
    {
        foreach (self::cases() as $genderEnum) {
            if ($genderEnum->getLabel() === $string) {
                return $genderEnum;
            }
        }
        return null;
    }
}
