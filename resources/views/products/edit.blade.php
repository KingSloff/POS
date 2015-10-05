@extends('layouts.master')

@section('title', 'Edit a Product')

@section('body')
    {!! Form::model($product, ['route' => ['product.update', $product], 'method' => 'put']) !!}

    @include('products.parts.product-fields')

    <div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{$product->getShowLink()}}" class="btn btn-default">Cancel</a>
    </div>

    {!! Form::close() !!}
@endsection