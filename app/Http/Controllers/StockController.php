<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\Stock\CreateStockEntryRequest;
use App\Http\Requests\Product\Stock\UpdateStockEntryRequest;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('stocks.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateStockEntryRequest|Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStockEntryRequest $request, Product $product)
    {
        $product->stocks()->create([
            'amount' => $request->amount,
            'in_stock' => $request->amount,
            'cost' => $request->cost
        ]);

        return redirect()->route('product.show', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @param  Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit($product, $stock)
    {
        return view('stocks.edit', compact('product', 'stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStockEntryRequest|Request $request
     * @param  Product $product
     * @param  Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStockEntryRequest $request, Product $product, Stock $stock)
    {
        $stock->cost = $request->cost;
        $stock->amount = $request->amount;
        $stock->in_stock = $request->amount;

        $stock->save();

        return redirect()->route('product.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @param  Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Stock $stock)
    {
        $stock->delete();

        return redirect()->route('product.show', $product);
    }
}
