<?php

namespace App\Infrastructure\Support\Helpers;

class StringHelper
{
    public static function generateRandomPassword(int $length = 12): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';

        return substr(str_shuffle(str_repeat($chars, 3)), 0, $length);
    }
}
