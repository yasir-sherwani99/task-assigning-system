<?php

namespace App\Helpers;

class CustomHelper 
{
    public static function calculatePercentage($value, $total)
    {
        $percentage = ($value / $total) * 100;
        return ceil($percentage);
    }
}