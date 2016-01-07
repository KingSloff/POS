<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartItem;
use App\Checkout;
use App\Http\Requests\Cart\CheckoutRequest;
use App\Http\Requests\CartItem\CreateCartItemRequest;
use App\Http\Requests\CartItem\UpdateCartItemRequest;
use App\Product;
use App\Services;
use App\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

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
        $users = User::all();

        $cart = Cart::with('cart_items.product.stocks')->first();

        $cartItems = $cart->cart_items;

        return view('checkout.index', compact('products', 'cart', 'cartItems', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCartItemRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCartItemRequest $request)
    {
        $cart = Cart::with('cart_items.product.stocks')->first();

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
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('checkout.index');
    }

    /**
     * Checkout event
     *
     * @param CheckoutRequest $request
     * @param Cart $cart
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(CheckoutRequest $request, Cart $cart)
    {
        foreach($cart->cart_items as $cartItem)
        {
            $numberToDeduct = $cartItem->amount;

            $product = $cartItem->product;

            if($product->in_stock < $numberToDeduct)
            {
                return redirect()->route('checkout.index')->withErrors('Not enough of product: '.$product->name);
            }
        }

        $cash = $request->has('cash');
        $total = $cart->total();
        $change = 0;

        if($cash)
        {
            $amountGiven = $request->amountGiven;

            if($amountGiven < $total)
            {
                return redirect()->route('checkout.index')->withErrors('Not enough money given');
            }
            else
            {
                $change = $amountGiven - $total;
            }
        }

        DB::transaction(function() use($request, $cart, $cash, $total)
        {
            if (!$cash)
                $user = User::findOrFail($request->user_id);

            foreach($cart->cart_items as $cartItem)
            {
                $numberToDeduct = $cartItem->amount;

                $product = $cartItem->product;

                if (!$cash)
                    $user->balance -= ($product->price * $numberToDeduct);

                $stocks = $product->stocks()->hasStock()->get();

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

                        if (!$cash)
                            $product->sales()->create([
                                'price' => $product->price,
                                'amount' => $numberToDeduct,
                                'cpu' => $stock->cpu,
                                'user_id' => $request->user_id
                            ]);
                        else
                        {
                            $product->sales()->create([
                                'price' => $product->price,
                                'amount' => $numberToDeduct,
                                'cpu' => $stock->cpu
                            ]);
                        }

                        break;
                    }
                    else
                    {
                        if(!$cash)
                        {
                            $product->sales()->create([
                                'price' => $product->price,
                                'amount' => $stock->in_stock,
                                'cpu' => $stock->cpu,
                                'user_id' => $request->user_id
                            ]);
                        }
                        else
                        {
                            $product->sales()->create([
                                'price' => $product->price,
                                'amount' => $stock->in_stock,
                                'cpu' => $stock->cpu
                            ]);
                        }

                        $numberToDeduct -= $stock->in_stock;

                        $stock->in_stock = 0;
                        $stock->save();
                    }
                }

                $product->updateStock();

                $cartItem->delete();
            }

            if(!$cash)
            {
                $user->save();

                $services = new Services();

                $user->logs()->create([
                    'title' => 'Goods Purchased',
                    'description' => $services->displayCurrency($total).' worth of items have been purchased.',
                    'details' => "Balance\t=>\t".$services->displayCurrency($user->balance)
                ]);
            }
        });

        if($change == 0)
        {
            return redirect()->route('checkout.index')->with('success', 'Purchase made');
        }
        else
        {
            $service = new Services();

            return redirect()->route('checkout.index')->with('success',
                'Purchase made. Change: '.$service->displayCurrency($change));
        }
    }
}
