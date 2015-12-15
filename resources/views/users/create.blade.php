@extends('layouts.master')

@section('title', 'Create a User')

@section('body')
    {!! Form::open(['route' => 'user.store']) !!}

    @include('users.parts.user-fields')

    <div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{route('user.index')}}" class="btn btn-default">Cancel</a>
    </div>

    {!! Form::close() !!}
@endsection