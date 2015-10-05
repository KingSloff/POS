<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Product', 5)->create()->each(function($product)
        {
            $product->stocks()->saveMany(factory('App\Stock', 2)->make());
        });
    }
}