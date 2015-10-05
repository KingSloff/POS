@extends('layouts.master')

@section('title', 'Create a Stock Entry')

@section('body')
    {!! Form::open(['route' => ['product.stock.store', $product]]) !!}

    @include('stocks.parts.stock-fields')

    <div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{route('product.show', ['product' => $product])}}" class="btn btn-default">Cancel</a>
    </div>

    {!! Form::close() !!}
@endsection