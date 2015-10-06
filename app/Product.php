<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
    protected $guarded = [];

    /**
     * Number of this product currently in stock
     */
    public function inStock()
    {
        $count = 0;

        foreach($this->stocks as $stock)
        {
            $count += $stock->amount;
        }

        return $count;
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
            return '0.00%';
        }

        return Services::displayAmount($smallest->profitPercentageRaw()).'%';
    }

    /**
     * Stock with the lowest profit percentage
     *
     * @return Stock
     */
    public function smallestProfitPercentageStock()
    {
        $smallest = null;

        foreach($this->stocks as $stock)
        {
            if($smallest == null)
            {
                $smallest = $stock;
            }
            else if($stock->profitPercentageRaw() < $smallest->profitPercentageRaw())
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
        if($this->smallestProfitPercentageStock() == null)
        {
            return 'N/A';
        }

        return Services::displayAmount(($this->smallestProfitPercentageStock()->cpu() * $this->target_profit_percentage / 100) + $this->smallestProfitPercentageStock()->cpu());
    }

    /**
     * A product has many stock entries
     */
    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }
}
