<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the link to show a product
     *
     */
    public function getShowLink()
    {
        return route('product.show', $this);
    }

    /**
     * Get the link to edit a product
     *
     */
    public function getEditLink()
    {
        return route('product.edit', $this);
    }

    /**
     * A product has many stock entries
     */
    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }
}
