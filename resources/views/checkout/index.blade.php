@extends('layouts.master')

@section('title', 'Checkout')

@section('body')
    <h1>Checkout</h1>

    <div class="col-sm-3">
        {!! Form::open(['route' => 'checkout.store']) !!}

        <div class="form-group">
            <label for="item">Item</label>
            <select name="product_id" class="form-control">
                <option selected disabled>Please select a product</option>
                @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Add Item</button>

        {!! Form::close() !!}
    </div>

    <div class="col-sm-9">
        <div class="">
            <table class="table table-striped">
                <colgroup>
                    <col span="1" style="width: 25%;">
                    <col span="1" style="width: 25%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 10%;">
                </colgroup>
                <thead>
                <tr>
                    <td><strong>Product</strong></td>
                    <td><strong>Amount</strong></td>
                    <td><strong>In stock</strong></td>
                    <td><strong>Cost Per Item</strong></td>
                    <td><strong>Total</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($cartItems as $cartItem)
                    <tr>
                        <td>{{$cartItem->product->name}}</td>
                        <td>
                            {!! Form::open(['route' => ['checkout.update', $cartItem], 'method' => 'put', 'style' => 'float: left']) !!}

                            {{$cartItem->amount}}

                            <input type="hidden" name="amount" value="{{$cartItem->amount + 1}}" />
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>

                            {!! Form::close() !!}

                            {!! Form::open(['route' => ['checkout.update', $cartItem], 'method' => 'put']) !!}

                            <input type="hidden" name="amount" value="{{$cartItem->amount - 1}}" />
                            <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-minus"></span></button>

                            {!! Form::close() !!}
                        </td>
                        <td>{{$cartItem->product->inStock()}}</td>
                        <td>{{$cartItem->product->price}}</td>
                        <td>{{$cartItem->prettyTotal()}}</td>
                        <td>
                            {!! Form::open(['route' => ['checkout.destroy', $cartItem], 'method' => 'delete']) !!}

                            <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>

                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-offset-3 col-sm-7">
        <h3>Total: {{$cart->prettyTotal()}}</h3>
    </div>

    <div class="col-sm-2">
        {!! Form::open(['route' => ['checkout.checkout', $cart]]) !!}

        <button type="submit" class="btn btn-primary btn-block">Checkout</button>

        {!! Form::close() !!}
    </div>
@endsection