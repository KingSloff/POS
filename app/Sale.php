<?php

namespace App;

use App\Traits\DateRangeTrait;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use DateRangeTrait;

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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total',
        'profit_percentage'
    ];

    /**
     * Total made on purchase
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->amount;
    }

    /**
     * Profit percentage made on purchase
     */
    public function getProfitPercentageAttribute()
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
