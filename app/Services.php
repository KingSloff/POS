<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    /**
     * Format a number as xxxx.xx
     *
     * @param $number
     * @return string
     */
    public static function displayAmount($number)
    {
        return number_format(round($number, 2), 2, '.', '');
    }

    /**
     * Set active navbar element as active
     *
     * @param $route
     * @param $name
     * @return string
     */
    public static function isActive($route, $name)
    {
        if (method_exists($route, 'getName'))
        {
            if (str_is($name.'*', $route->getName()))
                return 'active';

            return '';
        }
        else
        {
            return '';
        }
    }
}
