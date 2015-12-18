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
    public function profitPercentage()
    {
        $smallest = $this->smallestProfitPercentageStock();

        if($smallest == null)
        {
            return 0;
        }

        return $smallest->profitPercentage();
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
            else if($stock->profitPercentage() < $smallest->profitPercentage())
            {
                $smallest = $stock;
            }
        }

        return $smallest;
    }

    /**
     * Suggested price in order to meet target profit percentage
     */
    public function suggestedPrice()
    {
        $smallest = $this->smallestProfitPercentageStock();

        if($smallest == null)
        {
            return 'N/A';
        }

        return ($smallest->cpu() * $this->target_profit_percentage / 100) + $smallest->cpu();
    }

    /**
     * Profit made on this product
     */
    public function profit()
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
    public function profitPercentageMade()
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

        return $this->profit() / $totalCost * 100;
    }

    /**
     * Purchases per day
     */
    public function purchasesPerDay()
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
    public function averageDailyDemand()
    {
        $purchasesPerDay = $this->purchasesPerDay();

        if($purchasesPerDay == null)
        {
            return 0;
        }

        return array_sum($purchasesPerDay) / count($purchasesPerDay);
    }

    /**
     * Standard deviation of daily demand
     */
    public function sdDailyDemand()
    {
        $purchasesPerDay = $this->purchasesPerDay();

        if($purchasesPerDay == null)
        {
            return 0;
        }

        return Services::stats_standard_deviation($purchasesPerDay);
    }

    /**
     * Lead times
     */
    public function leadTimes()
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
    public function averageLeadTime()
    {
        $leadTimes = $this->leadTimes();

        if($leadTimes == null)
        {
            return 0;
        }

        return array_sum($leadTimes) / count($leadTimes);
    }

    /**
     * Standard deviation of lead time
     */
    public function sdLeadTime()
    {
        $leadTimes = $this->leadTimes();

        if($leadTimes == null)
        {
            return 0;
        }

        return Services::stats_standard_deviation($leadTimes);
    }

    /**
     * Reorder point
     */
    public function reorderPoint()
    {
        $result =
            ($this->averageDailyDemand() * $this->averageLeadTime()) +
            (Services::normSInv(0.95) * (
                sqrt( ($this->averageLeadTime() * pow($this->sdDailyDemand(), 2)) + (pow($this->averageDailyDemand(), 2) * pow($this->sdLeadTime(), 2)) )
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
