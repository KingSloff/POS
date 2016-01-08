@extends('layouts.master')

@section('title', 'Trial Balance')

@inject('services', 'App\Services')

@section('body')
	<div>
        <h2>
            <a href="{{route('report.index')}}" class="glyphicon glyphicon-chevron-left"></a>
            Trial Balance
        </h2>

        <br>
        <div class="row">
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
                <col span="1" style="width: 80%;">
                <col span="1" style="width: 10%;">
                <col span="1" style="width: 10%;">
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
                <td><strong>{{$services->displayAmount($report->total_debit1)}}</strong></td>
                <td><strong>{{$services->displayAmount($report->total_credit1)}}</strong></td>
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
                <td>{{$services->displayAmount($report->cumulative_profit)}}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{$services->displayAmount($report->total_debit2)}}</strong></td>
                <td><strong>{{$services->displayAmount($report->total_credit2)}}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection