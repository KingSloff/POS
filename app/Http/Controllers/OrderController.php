<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\Order\CreateOrderRequest;
use App\Http\Requests\Product\Order\UpdateOrderRequest;
use App\Order;
use App\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('orders.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateOrderRequest|Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request, Product $product)
    {
        $product->orders()->create([
            'amount' => $request->amount,
            'cost' => $request->cost
        ]);

        return redirect()->route('product.show', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Order $order)
    {
        return view('orders.edit', compact('product', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequest|Request $request
     * @param  Product $product
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Product $product, Order $order)
    {
        $order->cost = $request->cost;
        $order->amount = $request->amount;

        $order->save();

        return redirect()->route('product.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Order $order)
    {
        $order->delete();

        return redirect()->route('product.show', $product);
    }

    /**
     * Complete the order
     *
     * @param  Product  $product
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function complete(Product $product, Order $order)
    {
        $dateOrdered = Carbon::parse($order->created_at);
        $lead_time = $dateOrdered->diffInDays(Carbon::now());

        $product = DB::transaction(function() use($product, $order, $lead_time)
        {
            $product->stocks()->create([
                'amount' => $order->amount,
                'in_stock' => $order->amount,
                'cost' => $order->cost,
                'lead_time' => $lead_time
            ]);

            $product->updateStock();

            return $product;
        });

        $order->delete();

        return redirect()->route('product.show', $product);
    }
}
