<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\WriteOffProductRequest;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(new Product());

        $products = Product::sortable()->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize(new Product());

        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $this->authorize(new Product());

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'target_profit_percentage' => $request->target_profit_percentage,
        ]);

        return redirect()->route('product.show', $product)->with('success', 'Product successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize($product);

        $sales = $product->sales;

        return view('products.show', compact('product', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize($product);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest|Request $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize($product);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->target_profit_percentage = $request->target_profit_percentage;

        $product->save();

        return redirect()->route('product.show', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize($product);

        $product->delete();

        return redirect()->route('product.index');
    }

    /**
     * Write off some of the stock
     *
     * @param WriteOffProductRequest $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function writeOff(WriteOffProductRequest $request, Product $product)
    {
        $this->authorize($product);

        $writeOff = $request->amountToWriteOff;

        if($writeOff > $product->in_stock)
        {
            return redirect()->route('product.show', $product)->withInput()->withErrors('Incorrect amount entered');
        }

        DB::transaction(function() use($product, $writeOff)
        {
            $stocks = $product->stocks()->hasStock()->get();

            foreach($stocks as $stock)
            {
                if($stock->in_stock == 0)
                {
                    continue;
                }
                if($stock->in_stock - $writeOff >= 0)
                {
                    $stock->in_stock -= $writeOff;

                    $stock->save();

                    $product->sales()->create([
                        'price' => 0,
                        'amount' => $writeOff,
                        'cpu' => $stock->cpu()
                    ]);

                    break;
                }
                else
                {
                    $product->sales()->create([
                        'price' => 0,
                        'amount' => $stock->in_stock,
                        'cpu' => $stock->cpu()
                    ]);

                    $writeOff -= $stock->in_stock;

                    $stock->in_stock = 0;
                    $stock->save();
                }
            }

            $product->updateStock();
        });

        return redirect()->route('product.show', $product)->with('success', 'Stock written off');
    }
}
