<?php

namespace App\Traits;

trait EnumHelper
{
    public static function isValid(string $value): bool
    {
        return in_array($value, self::toArray());
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
