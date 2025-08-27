<?php

namespace App\Helpers;

class PhoneHelper
{
    public static function getLastNineDigits($phone)
    {
        $digitsOnly = preg_replace('/\D/', '', $phone);

        return substr($digitsOnly, -9);
    }
}
