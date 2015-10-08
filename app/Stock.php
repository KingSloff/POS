<?php

namespace App;

use Cache;
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
        return $this->cost / $this->amount;
    }

    /**
     * Profit percentage
     */
    public function profitPercentage()
    {
        $product = Cache::rememberForever('stock_'.$this->id.'product', function()
        {
            return $this->product;
        });

        return ($product->price - $this->cpu()) / $this->cpu() * 100;
    }

    /**
     * A stock entry belongs to a single product
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * Get only elements in stock
     */
    public function scopeHasStock($query)
    {
        return $query->where('in_stock', '>', 0);
    }
}
