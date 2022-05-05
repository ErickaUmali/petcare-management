<?php

namespace App\Helpers;

class UserHelper
{
    public static function numbers($length = 1)
    {
        $numbers = '';

        for ($i = 0; $i < $length; $i++) {
            $numbers = $numbers . rand(0, 9);
        }

        return $numbers;
    }
}
