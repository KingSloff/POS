<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cart_items';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Total cost of item
     */
    public function total()
    {
        return $this->amount * $this->product->price;
    }

    public function prettyTotal()
    {
        return Services::displayAmount($this->total());
    }

    /**
     * A cart item refers to one product
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * A cart item belongs to a cart
     */
    public function cart()
    {
        return $this->belongsTo('App\Cart');
    }
}
