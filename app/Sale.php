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

    /**
     * Profit percentage made on purchase
     */
    public function profitPercentage()
    {
        if($this->cpu == 0)
        {
            return 0;
        }

        return ($this->price - $this->cpu) / $this->cpu * 100;
    }

    /**
     * A sale belongs to a product
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * A sale belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
