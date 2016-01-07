@extends('layouts.master')

@section('title', 'Lists')

@section('body')
    <div>
        <h2>
            <a href="{{route('report.index')}}" class="glyphicon glyphicon-chevron-left"></a>
            Lists
        </h2>

        <div class="row">
            <div class="col-sm-3">
                {{ Form::open(['route' => 'report.lists', 'method' => 'get']) }}

                <div class="form-group">
                    <label for="date">Date</label>
                    <input class="form-control" name="date" type="month">
                </div>

                <button type="submit" class="btn btn-success">Submit</button>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection