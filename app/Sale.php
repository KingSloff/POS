<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Total made on purchase
     */
    public function total()
    {
        return $this->price * $this->amount;
    }

    public function prettyTotal()
    {
        return Services::displayAmount($this->total());
    }

    /**
     * Profit percentage made on purchase
     */
    public function profitPercentage()
    {
        return ($this->price - $this->cpu) / $this->cpu * 100;
    }

    public function prettyProfitPercentage()
    {
        return Services::displayAmount($this->profitPercentage()).'%';
    }

    /**
     * A sale belongs to a product
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
