@extends('layouts.master')

@section('title', 'Trial Balance')

@inject('services', 'App\Services')

@section('body')
	<div>
        <h2>
            <a href="{{route('report.index')}}" class="glyphicon glyphicon-chevron-left no-print"></a>
            Trial Balance
        </h2>

        <br>
        <div class="row no-print">

            {{ Form::open(['route' => 'report.trial-balance', 'method' => 'get']) }}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="from">From</label>
                    {{Form::input('month', 'from', Input::get('from'), ['class' => 'form-control'])}}
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="to">To</label>
                    {{Form::input('month', 'to', Input::get('to'), ['class' => 'form-control'])}}
                </div>
            </div>
            {{ Form::close() }}

            <div class="col-sm-3">
                {{ Form::open(['route' => ['report.trial-balance.bank']]) }}

                <div class="form-group">
                    <label for="amountToBank">Amount to Bank</label>
                    {{ Form::text('amountToBank', null, ['class' => 'form-control']) }}
                </div>

                <button type="submit" class="btn btn-success">Bank</button>

                {{ Form::close() }}
            </div>
        </div>
        <br>

        <table class="table table-striped">
            <colgroup>
                <col span="1" style="width: 70%;">
                <col span="1" style="width: 15%;">
                <col span="1" style="width: 15%;">
            </colgroup>
            <thead>
            <tr>
                <td><strong>Description</strong></td>
                <td><strong>Debits</strong></td>
                <td><strong>Credits</strong></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Sales</td>
                <td></td>
                <td>{{$services->displayAmount($report->sales)}}</td>
            </tr>
            <tr>
                <td>Opening Inventory</td>
                <td>{{$services->displayAmount($report->opening_inventory)}}</td>
                <td></td>
            </tr>
            <tr>
                <td>Purchases</td>
                <td>{{$services->displayAmount($report->purchases)}}</td>
                <td></td>
            </tr>
            <tr>
                <td>Closing Inventory</td>
                <td></td>
                <td>{{$services->displayAmount($report->closing_inventory)}}</td>
            </tr>
            <tr>
                @if($report->profit >= 0)
                    <td>Profit</td>
                    <td>{{$services->displayAmount($report->profit)}}</td>
                    <td></td>
                @else
                    <td>Loss</td>
                    <td></td>
                    <td>{{$services->displayAmount(abs($report->profit))}}</td>
                @endif
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{$services->displayAmount($report->totalDebits1())}}</strong></td>
                <td><strong>{{$services->displayAmount($report->totalCredits1())}}</strong></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Cash</td>
                <td>{{$services->displayAmount($report->cash)}}</td>
                <td></td>
            </tr>
            <tr>
                <td>Bank</td>
                <td>{{$services->displayAmount($report->bank)}}</td>
                <td></td>
            </tr>
            <tr>
                <td>Debtors</td>
                <td>{{$services->displayAmount(abs($report->total_debtors))}}</td>
                <td></td>
            </tr>
            <tr>
                <td>Creditors</td>
                <td></td>
                <td>{{$services->displayAmount($report->total_creditors)}}</td>
            </tr>
            <tr>
                <td>Closing Inventory</td>
                <td>{{$services->displayAmount($report->closing_inventory)}}</td>
                <td></td>
            </tr>
            <tr>
                <td>Cumulative Profit</td>
                <td></td>
                <td>{{$services->displayAmount($report->cumulativeProfit())}}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{$services->displayAmount($report->totalDebits2())}}</strong></td>
                <td><strong>{{$services->displayAmount($report->totalCredits2())}}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection