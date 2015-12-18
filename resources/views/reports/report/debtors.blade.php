@extends('layouts.master')

@section('title', 'Debtors')

@inject('services', 'App\Services')

@section('body')
    <div>
        <h2>
            <a href="{{route('report.index')}}" class="glyphicon glyphicon-chevron-left"></a>
            Debtors
        </h2>

        @include('users.parts.users')
    </div>
@endsection