<?php

namespace App\Infrastructure\Support\Helpers;

class DateHelper
{
    public static function isNightShift($time): bool
    {
        $hour = date('G', strtotime($time));

        return $hour >= 22 || $hour < 6;
    }

    public static function isFeatureNewlyReleased($date): bool
    {
        return now()->diffInDays($date) <= 30;
    }
}
