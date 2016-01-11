<?php

namespace App;

use App\Traits\DateRangeTrait;
use App\Traits\SortableTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SortableTrait, DateRangeTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * A user has many sales
     */
    public function sales()
    {
        return $this->hasMany('App\Sale');
    }

    /**
     * A user has many log entries
     */
    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    /**
     * A user makes many payments/loans
     */
    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    /**
     * Filter users who have debt
     * @param $query
     * @return
     */
    public function scopeHasDebt($query)
    {
        return $query->where('balance', '<', 0);
    }
}
