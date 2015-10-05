@extends('layouts.master')

@section('title', 'Create a Product')

@section('body')
    {!! Form::open(['route' => 'product.store']) !!}

    @include('products.parts.product-fields')

    <div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{route('product.index')}}" class="btn btn-default">Cancel</a>
    </div>

    {!! Form::close() !!}
@endsection