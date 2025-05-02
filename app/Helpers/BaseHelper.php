<?php

namespace App\Helpers;

class BaseHelper
{
    public static function isPrefixOfAny(string $needle, array $haystack): bool
    {
        foreach ($haystack as $string) {
            if (str_starts_with($needle, $string)) {
                return true;
            }
        }
        return false;
    }
}
