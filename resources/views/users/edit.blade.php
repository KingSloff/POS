@extends('layouts.master')

@section('title', 'Edit a User')

@section('body')
    {{ Form::model($user, ['route' => ['user.update', $user], 'method' => 'put']) }}

    @include('users.parts.user-fields')

    <div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{route('user.show', $user)}}" class="btn btn-default">Cancel</a>
    </div>

    {{ Form::close() }}
@endsection