@extends('layouts.master')

@section('title', 'Checkout')

@inject('services', 'App\Services')

@section('body')
    <div class="col-sm-3">
        {!! Form::open(['route' => 'checkout.store']) !!}

        <div class="form-group">
            <label for="item">Item</label>
            <select name="product_id" class="form-control">
                <option selected disabled>Please select a product</option>
                @foreach($products as $product)
                    @if($product->inStock() > 0)
                    <option value="{{$product->id}}">
                        {{$product->name}}
                    </option>
                    @endif
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Add Item</button>

        {!! Form::close() !!}
    </div>

    <div class="col-sm-9">
        <div class="table-responsive">
            <table class="table table-striped">
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
                            {{$cartItem->amount}}

                            <div>
                            {!! Form::open(['route' => ['checkout.update', $cartItem], 'method' => 'put', 'style' => 'display: inline-block;']) !!}

                            <input type="hidden" name="amount" value="{{$cartItem->amount + 1}}" />
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>

                            {!! Form::close() !!}

                            {!! Form::open(['route' => ['checkout.update', $cartItem], 'method' => 'put', 'style' => 'display: inline-block;']) !!}

                            <input type="hidden" name="amount" value="{{$cartItem->amount - 1}}" />
                            <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-minus"></span></button>

                            {!! Form::close() !!}
                            </div>
                        </td>
                        <td>{{$cartItem->product->inStock()}}</td>
                        <td>{{$services->displayCurrency($cartItem->product->price)}}</td>
                        <td>{{$services->displayCurrency($cartItem->total())}}</td>
                        <td>
                            {!! Form::open(['route' => ['checkout.destroy', $cartItem], 'method' => 'delete']) !!}

                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>

                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-offset-3 col-sm-7">
        <h3>Total: {{$services->displayCurrency($cart->total())}}</h3>
    </div>

    <div class="col-sm-2">
        {!! Form::open(['route' => ['checkout.checkout', $cart]]) !!}

        <div>
            {!! Form::checkbox('cash', 'on') !!} Cash
        </div>

        <div id="amountGivenDiv" class="form-group">
            <label for="amountGiven">Amount Given</label>
            {!! Form::text('amountGiven', null, ['class' => 'form-control']) !!}
        </div>

        <div id="userDiv" class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" class="form-control">
                <option selected disabled>Please select a user</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">
                        {{$user->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Checkout</button>

        {!! Form::close() !!}
    </div>
@endsection