@extends('layouts.master')

@section('title', 'User | '.$user->name)

@inject('services', 'App\Services')

@section('body')
    <div>
        <h2>
            {!! Form::open(['route' => ['user.destroy', $user], 'method' => 'delete']) !!}
            <a href="{{route('user.index')}}" class="glyphicon glyphicon-chevron-left"></a>
            {{$user->name}}

            <div style="float: right">
                <a href="{{route('user.edit', $user)}}" class="btn btn-primary">Edit</a>
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
                    <td><strong>Name</strong></td>
                    <td>{{$user->name}}</td>

                    <td><strong>Email</strong></td>
                    <td>{{$user->email}}</td>
                </tr>
                <tr>
                    <td><strong>Balance</strong></td>
                    <td>{{$services->displayCurrency($user->balance)}}</td>

                    <td><strong></strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-sm-3">
                {!! Form::open(['route' => ['user.pay', $user]]) !!}

                <div class="form-group">
                    <label for="amountToPay">Amount to Pay</label>
                    {!! Form::text('amountToPay', null, ['class' => 'form-control']) !!}
                </div>

                <button type="submit" class="btn btn-success">Pay</button>

                {!! Form::close() !!}
            </div>

            <div class="col-sm-3">
                {!! Form::open(['route' => ['user.loan', $user]]) !!}

                <div class="form-group">
                    <label for="amountToLoan">Amount to Loan</label>
                    {!! Form::text('amountToLoan', null, ['class' => 'form-control']) !!}
                </div>

                <button type="submit" class="btn btn-success">Loan</button>

                {!! Form::close() !!}
            </div>
        </div>

        <br/>

        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#sales">Sales</a></li>

                <li><a data-toggle="tab" href="#logs">Logs</a></li>
            </ul>
            <div class="tab-content">
                <div id="sales" class="tab-pane fade in active">
                    @include('sales.parts.user-sales')
                </div>

                <div id="logs" class="tab-pane fade">
                    @include('logs.parts.logs')
                </div>
            </div>
        </div>
    </div>
@endsection