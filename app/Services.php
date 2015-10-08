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
    public function displayAmount($number)
    {
        return number_format(round($number, 2), 2, '.', ',');
    }

    /**
     * Format a number as currency
     *
     * @param $number
     * @return string
     */
    public function displayCurrency($number)
    {
        return 'R '.$this->displayAmount($number);
    }

    /**
     * Format a number as a percentage
     *
     * @param $number
     * @return string
     */
    public function displayPercentage($number)
    {
        return $this->displayAmount($number).' %';
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
