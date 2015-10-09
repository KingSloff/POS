@extends('layouts.master')

@section('title', 'Edit an Order')

@section('body')
    {!! Form::model($order, ['route' => ['product.order.update', $product, $order], 'method' => 'put']) !!}

    @include('orders.parts.order-fields')

    <div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{route('product.show', $product)}}" class="btn btn-default">Cancel</a>
    </div>

    {!! Form::close() !!}
@endsection