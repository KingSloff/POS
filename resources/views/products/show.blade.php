@extends('layouts.master')

@section('title', 'Product | '.$product->name)

@section('body')
    <div>
        <h2>
            {!! Form::open(['route' => ['product.destroy', $product], 'method' => 'delete']) !!}
            <a href="{{route('product.index')}}" class="glyphicon glyphicon-chevron-left"></a>
            {{$product->name}}

            <div style="float: right">
                <a href="{{route('product.edit', $product)}}" class="btn btn-primary">Edit</a>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            {!! Form::close() !!}
        </h2>

        <table class="table table-striped">
            <colgroup>
                <col span="1" style="width: 10%;">
                <col span="1" style="width: 40%;">
                <col span="1" style="width: 10%;">
                <col span="1" style="width: 40%;">
            </colgroup>
            <tbody>
                <tr>
                    <td><strong>Price</strong></td>
                    <td>{{$product->price}}</td>

                    <td><strong>Suggested Price</strong></td>
                    <td>{{$product->suggestedPrice()}}</td>
                </tr>
                <tr>
                    <td><strong>Profit Percentage</strong></td>
                    <td>{{$product->profitPercentage()}}</td>

                    <td><strong>Stock</strong></td>
                    <td>{{$product->inStock()}}</td>
                </tr>
            </tbody>
        </table>

        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#stock">Stock</a></li>
            </ul>
            <div class="tab-content">
                <div id="stock" class="tab-pane fade in active">
                    @include('stocks.parts.stocks')
                </div>
            </div>
        </div>

        <a href="{{route('product.stock.create', ['product' => $product])}}" class="btn btn-primary">Add Stock Entry</a>
    </div>
@endsection