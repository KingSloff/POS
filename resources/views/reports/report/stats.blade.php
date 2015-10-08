@extends('layouts.master')

@section('title', 'Basic Stats')

@inject('services', 'App\Services')

@section('body')
	<div>
        <h2>
            <a href="{{route('report.index')}}" class="glyphicon glyphicon-chevron-left"></a>
            Stats
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
                    <td><strong>Income</strong></td>
                    <td>{{$services->displayCurrency($report->income)}}</td>

                    <td><strong>Expenses</strong></td>
                    <td>{{$services->displayCurrency($report->expenses)}}</td>
                </tr>
                <tr>
                    <td><strong>Profit</strong></td>
                    <td>{{$services->displayCurrency($report->profit)}}</td>

                    <td><strong>Profit Percentage</strong></td>
                    <td>{{$services->displayPercentage($report->profit_percentage)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection