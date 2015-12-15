@extends('layouts.master')

@section('title', 'User | '.$user->name)

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
            </tbody>
        </table>
    </div>
@endsection