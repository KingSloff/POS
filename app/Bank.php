<?php

namespace App;

use App\Traits\DateRangeTrait;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use DateRangeTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bank';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
