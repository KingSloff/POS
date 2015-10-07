<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartItem;
use App\Checkout;
use App\Http\Requests\CartItem\CreateCartItemRequest;
use App\Http\Requests\CartItem\UpdateCartItemRequest;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        $cart = Cart::first();
        $cartItems = $cart->cart_items;

        return view('checkout.index', compact('products', 'cart', 'cartItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCartItemRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCartItemRequest $request)
    {
        $cart = Cart::first();

        foreach($cart->cart_items as $cartItem)
        {
            if($cartItem->product_id == $request->product_id)
            {
                $cartItem->amount++;
                $cartItem->save();

                return redirect()->route('checkout.index');
            }
        }

        $cart->cart_items()->create([
            'product_id' => $request->product_id,
            'amount' => 1
        ]);

        return redirect()->route('checkout.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCartItemRequest|Request $request
     * @param  CartItem $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cartItem->amount = $request->amount;

        $cartItem->save();

        return redirect()->route('checkout.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($cartItem)
    {
        $cartItem->delete();

        return redirect()->route('checkout.index');
    }

    /**
     * Checkout event
     *
     * @param Cart $cart
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Cart $cart)
    {
        foreach($cart->cart_items as $cartItem)
        {
            $numberToDeduct = $cartItem->amount;

            $product = $cartItem->product;

            if($product->inStock() < $numberToDeduct)
            {
                return redirect()->route('checkout.index')->withErrors('Not enough of product: '.$product->name);
            }

            $stocks = $product->stocks;

            foreach($stocks as $stock)
            {
                if($stock->in_stock == 0)
                {
                    continue;
                }
                if($stock->in_stock - $numberToDeduct >= 0)
                {
                    $stock->in_stock -= $numberToDeduct;

                    $stock->save();

                    $product->sales()->create([
                        'price' => $product->price,
                        'amount' => $numberToDeduct,
                        'cpu' => $stock->cpu()
                    ]);

                    break;
                }
                else
                {
                    $product->sales()->create([
                        'price' => $product->price,
                        'amount' => $stock->in_stock,
                        'cpu' => $stock->cpu()
                    ]);

                    $numberToDeduct -= $stock->in_stock;

                    $stock->in_stock = 0;
                    $stock->save();
                }
            }

            $cartItem->delete();
        }

        return redirect()->route('checkout.index')->with('success', 'Purchase made');
    }
}
