@extends('layouts.master')

@section('title', 'Product | '.$product->name)

@section('body')
    <div>
        ID: {{$product->id}} <br />
        Name: {{$product->name}} <br />

        <h2>Functions</h2>
        <a href="{{route('product.index')}}" class="btn btn-default">Back</a>

        <a href="{{$product->getEditLink()}}" class="btn btn-primary">Edit</a>

        {!! Form::open(['route' => ['product.destroy', $product], 'method' => 'delete']) !!}
        <button type="submit" class="btn btn-danger">Delete</button>
        {!! Form::close() !!}
    </div>
@endsection