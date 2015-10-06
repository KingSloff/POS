<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    /**
     * Format a number as xxxx.xx
     *
     * @param $number
     */
    public static function displayAmount($number)
    {
        return number_format(round($number, 2), 2, '.', '');
    }
}
