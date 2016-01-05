@extends('layouts.master')

@section('title', 'Basic Stats')

@inject('services', 'App\Services')

@section('body')
	<div>
        <h2>
            <a href="{{route('report.index')}}" class="glyphicon glyphicon-chevron-left"></a>
            Trial Balance
        </h2>

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
                    <td>Profit</td>
                    <td>{{$services->displayAmount($report->profit)}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{$services->displayAmount($report->totalDebit)}}</strong></td>
                    <td><strong>{{$services->displayAmount($report->totalCredit)}}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection