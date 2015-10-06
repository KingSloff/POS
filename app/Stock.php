<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stocks';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Calc the cost per unit
     *
     * @return string
     */
    public function cpu()
    {
        return Services::displayAmount($this->cost / $this->amount);
    }

    /**
     * Profit percentage
     */
    public function profitPercentage()
    {
        return Services::displayAmount($this->profitPercentageRaw()).'%';
    }

    public function profitPercentageRaw()
    {
        return ($this->product->price - $this->cpu()) / $this->cpu() * 100;
    }

    /**
     * Amount of stock remaining
     */
    public function stockRemaining()
    {
        $amount = $this->amount;

        foreach($this->sales as $sale)
        {
            $amount -= $sale->amount;
        }

        return $amount;
    }

    /**
     * A stock entry belongs to a single product
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * A stock entry has many sales
     */
    public function sales()
    {
        return $this->hasMany('App\Sale');
    }
}
