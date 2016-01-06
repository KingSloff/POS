<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * A user makes a payment/loan
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
