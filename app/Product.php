<?php

namespace App;

use App\Traits\SortableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SortableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'in_stock'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profit_percentage',
        'suggested_price',
        'profit',
        'profit_percentage_made',
        'purchases_per_day',
        'average_daily_demand',
        'sd_daily_demand',
        'lead_times',
        'average_lead_time',
        'sd_lead_time',
        'reorder_point'
    ];

    /**
     * Number of this product currently in stock
     */
    public function updateStock()
    {
        $count = 0;

        foreach($this->stocks()->hasStock()->get() as $stock)
        {
            $count += $stock->in_stock;
        }

        $this->in_stock = $count;

        $this->save();
    }

    /**
     * Lowest profit percentage
     *
     * @return String
     */
    public function getProfitPercentageAttribute()
    {
        $smallest = $this->smallestProfitPercentageStock();

        if($smallest == null)
        {
            return 0;
        }

        return $smallest->profit_percentage;
    }

    /**
     * Stock with the lowest profit percentage
     *
     * @return Stock
     */
    public function smallestProfitPercentageStock()
    {
        $smallest = null;

        foreach($this->stocks()->with('product')->hasStock()->get() as $stock)
        {
            if($smallest == null)
            {
                $smallest = $stock;
            }
            else if($stock->profit_percentage < $smallest->profit_percentage)
            {
                $smallest = $stock;
            }
        }

        return $smallest;
    }

    /**
     * Suggested price in order to meet target profit percentage
     */
    public function getSuggestedPriceAttribute()
    {
        $smallest = $this->smallestProfitPercentageStock();

        if($smallest == null)
        {
            return 'N/A';
        }

        return ($smallest->cpu * $this->target_profit_percentage / 100) + $smallest->cpu;
    }

    /**
     * Profit made on this product
     */
    public function getProfitAttribute()
    {
        $profit = 0;

        foreach($this->sales as $sale)
        {
            $profit += ($sale->price - $sale->cpu) * $sale->amount;
        }

        return $profit;
    }

    /**
     * Profit percentage made
     */
    public function getProfitPercentageMadeAttribute()
    {
        $totalCost = 0;

        foreach($this->sales as $sale)
        {
            $totalCost += $sale->cpu * $sale->amount;
        }

        if($totalCost == 0)
        {
            return 0;
        }

        return $this->profit / $totalCost * 100;
    }

    /**
     * Purchases per day
     */
    public function getPurchasesPerDayAttribute()
    {
        $sales = $this->sales;

        if(empty($sales[0]))
        {
            return null;
        }

        $dayOne = Carbon::parse($sales[0]->created_at);

        $purchasesPerDay = [];

        foreach($sales as $sale)
        {
            $day = $dayOne->diffInDays(Carbon::parse($sale->created_at));

            if(empty($purchasesPerDay[$day]))
            {
                $purchasesPerDay[$day] = $sale->amount;
            }
            else
            {
                $purchasesPerDay[$day] += $sale->amount;
            }
        }

        for($count = 0; $count < $dayOne->diffInDays(Carbon::now()); $count++)
        {
            if(empty($purchasesPerDay[$count]))
            {
                $purchasesPerDay[$count] = 0;
            }
        }

        return $purchasesPerDay;
    }

    /**
     * Average daily demand
     */
    public function getAverageDailyDemandAttribute()
    {
        $purchasesPerDay = $this->purchases_per_day;

        if($purchasesPerDay == null)
        {
            return 0;
        }

        return array_sum($purchasesPerDay) / count($purchasesPerDay);
    }

    /**
     * Standard deviation of daily demand
     */
    public function getSdDailyDemandAttribute()
    {
        $purchasesPerDay = $this->purchases_per_day;

        if($purchasesPerDay == null)
        {
            return 0;
        }

        return Services::stats_standard_deviation($purchasesPerDay);
    }

    /**
     * Lead times
     */
    public function getLeadTimesAttribute()
    {
        $stocks = $this->stocks;

        if(empty($stocks[0]))
        {
            return null;
        }

        $leadTimes = [];

        foreach($stocks as $stock)
        {
            if($stock->lead_time != null)
            {
                array_push($leadTimes, $stock->lead_time);
            }
        }

        return $leadTimes;
    }

    /**
     * Average lead time
     */
    public function getAverageLeadTimeAttribute()
    {
        $leadTimes = $this->lead_times;

        if($leadTimes == null)
        {
            return 0;
        }

        return array_sum($leadTimes) / count($leadTimes);
    }

    /**
     * Standard deviation of lead time
     */
    public function getSdLeadTimeAttribute()
    {
        $leadTimes = $this->lead_times;

        if($leadTimes == null)
        {
            return 0;
        }

        return Services::stats_standard_deviation($leadTimes);
    }

    /**
     * Reorder point
     */
    public function getReorderPointAttribute()
    {
        $result =
            ($this->average_daily_demand * $this->average_lead_time) +
            (Services::normSInv(0.95) * (
                sqrt( ($this->average_lead_time * pow($this->sd_daily_demand, 2)) + (pow($this->average_daily_demand, 2) * pow($this->sd_lead_time, 2)) )
            ));

        return ceil($result);
    }

    /**
     * A product has many stock entries
     */
    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }

    /**
     * A product has many sales
     */
    public function sales()
    {
        return $this->hasMany('App\Sale');
    }

    /**
     * A product has many cart items
     */
    public function cart_items()
    {
        return $this->hasMany('App\CartItem');
    }

    /**
     * A product has many orders
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
