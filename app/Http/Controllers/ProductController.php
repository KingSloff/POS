<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Product;
use Cache;
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

        $products = Cache::rememberForever('products', function()
        {
            return Product::get();
        });

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

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'target_profit_percentage' => $request->target_profit_percentage,
        ]);

        Cache::flush();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        $this->authorize($product);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
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
    public function update(UpdateProductRequest $request, $product)
    {
        $this->authorize($product);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->target_profit_percentage = $request->target_profit_percentage;

        $product->save();

        Cache::flush();

        return redirect()->route('product.show', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $this->authorize($product);

        $product->delete();

        Cache::flush();

        return redirect()->route('product.index');
    }
}
