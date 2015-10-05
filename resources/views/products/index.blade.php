@extends('layouts.master')

@section('title', 'Products')

@section('body')
    @include('products.parts.products')

    <a href="{{route('product.create')}}" class="btn btn-primary">Create</a>
@endsection