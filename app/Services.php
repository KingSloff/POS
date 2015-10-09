<?php

namespace App;

use Exception;
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

    /**
     * Stats functions
     */
    public static function stats_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
            --$n;
        }
        return sqrt($carry / $n);
    }

    public static function normSInv($p){
        $a1 = -39.6968302866538; $a2 = 220.946098424521; $a3 = -275.928510446969;
        $a4 = 138.357751867269; $a5 = -30.6647980661472; $a6 = 2.50662827745924;
        $b1 = -54.4760987982241; $b2 = 161.585836858041; $b3 = -155.698979859887;
        $b4 = 66.8013118877197; $b5 = -13.2806815528857; $c1 = -7.78489400243029E-03;
        $c2 = -0.322396458041136; $c3 = -2.40075827716184; $c4 = -2.54973253934373;
        $c5 = 4.37466414146497; $c6 = 2.93816398269878; $d1 = 7.78469570904146E-03;
        $d2 = 0.32246712907004; $d3 = 2.445134137143; $d4 = 3.75440866190742;
        $p_low = 0.02425; $p_high = 1 - $p_low;
        $q = 0.0; $r = 0.0;
        if($p < 0 || $p > 1){
           throw new Exception("NormSInv: Argument out of range.");
        } else if($p < $p_low){
           $q = pow(-2 * log($p), 2);
           $NormSInv = ((((($c1 * $q + $c2) * $q + $c3) * $q + $c4) * $q + $c5) * $q + $c6) /
               (((($d1 * $q + $d2) * $q + $d3) * $q + $d4) * $q + 1);
        } else if($p <= $p_high){
           $q = $p - 0.5; $r = $q * $q;
           $NormSInv = ((((($a1 * $r + $a2) * $r + $a3) * $r + $a4) * $r + $a5) * $r + $a6) * $q /
               ((((($b1 * $r + $b2) * $r + $b3) * $r + $b4) * $r + $b5) * $r + 1);
        } else {
           $q = pow(-2 * log(1 - $p), 2);
           $NormSInv = -((((($c1 * $q + $c2) * $q + $c3) * $q + $c4) * $q + $c5) * $q + $c6) /
               (((($d1 * $q + $d2) * $q + $d3) * $q + $d4) * $q + 1);
        }
            return $NormSInv;
        }
}
