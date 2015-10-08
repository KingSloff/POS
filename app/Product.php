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
            $count += $stock->in_stock;
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

        foreach($this->stocks()->hasStock()->get() as $stock)
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
        if($this->smallestProfitPercentageStock() == null)
        {
            return 'N/A';
        }

        return ($this->smallestProfitPercentageStock()->cpu() * $this->target_profit_percentage / 100) + $this->smallestProfitPercentageStock()->cpu();
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
}
