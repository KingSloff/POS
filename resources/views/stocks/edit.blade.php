@extends('layouts.master')

@section('title', 'Edit a Stock Entry')

@section('body')
    {!! Form::model($stock, ['route' => ['product.stock.update', $product, $stock], 'method' => 'put']) !!}

    @include('stocks.parts.stock-fields')

    <div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{route('product.show', $product)}}" class="btn btn-default">Cancel</a>
    </div>

    {!! Form::close() !!}
@endsection