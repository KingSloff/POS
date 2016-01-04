@extends('layouts.master')

@section('title', 'Login')

@section('body')
    {{ Form::open(['route' => 'login']) }}

    <div class="form-group">
        <label for="email">Email</label>
        {{ Form::email('email', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    <div>
        <input type="checkbox" name="remember"> Remember Me
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Login</button>
    </div>

    {{ Form::close() }}
@endsection