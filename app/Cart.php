<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Total in cart
     */
    public function total()
    {
        $total = 0;

        foreach($this->cart_items as $cartItem)
        {
            $total += $cartItem->total();
        }

        return $total;
    }

    public function prettyTotal()
    {
        return Services::displayAmount($this->total());
    }

    /**
     * A cart has many cart items
     */
    public function cart_items()
    {
        return $this->hasMany('App\CartItem');
    }
}
