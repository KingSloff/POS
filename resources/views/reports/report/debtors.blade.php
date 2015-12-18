@extends('layouts.master')

@section('title', 'Debtors')

@inject('services', 'App\Services')

@section('body')
    <div>
        <h2>
            <div class="row">
                <div class="col-sm-3">
                    <a href="{{route('report.index')}}" class="glyphicon glyphicon-chevron-left"></a>
                    Debtors
                </div>

                <div class="col-sm-offset-7 col-sm-2">
                    <a href="{{route('report.debtors.send-email')}}" class="btn btn-block btn-primary">Send Emails</a>
                </div>
            </div>
        </h2>

        @include('users.parts.users')
    </div>
@endsection