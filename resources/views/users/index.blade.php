@extends('layouts.master')

@section('title', 'Users')

@section('body')
    @include('users.parts.users')

    <a href="{{route('user.create')}}" class="btn btn-primary">Create</a>
@endsection