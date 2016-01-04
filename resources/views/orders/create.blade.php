@extends('layouts.master')

@section('title', 'Create an Order')

@section('body')
    {{ Form::open(['route' => ['product.order.store', $product]]) }}

    @include('orders.parts.order-fields')

    <div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{route('product.show', ['product' => $product])}}" class="btn btn-default">Cancel</a>
    </div>

    {{ Form::close() }}
@endsection