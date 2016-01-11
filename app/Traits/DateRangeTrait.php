<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateRangeTrait {
    public function scopeDateRange($query, $from, $to)
    {
        return $query->where('created_at', '>=', $from->toDateString())
            ->where('created_at', '<=', $to->toDateString());
    }

    public function scopeDateRangeTo($query, $to)
    {
        return $this->scopeDateRange($query, Carbon::minValue(), $to);
    }

    public function scopeDateRangeFrom($query, $from)
    {
        return $this->scopeDateRange($query, $from, Carbon::maxValue());
    }
}
