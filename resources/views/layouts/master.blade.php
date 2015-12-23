<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{elixir('css/all.css')}}" rel="stylesheet">
</head>

<body>

@include('layouts.nav')

<div class="container space-bottom">
    @include('success.success')

    @include('errors.errors')

    @yield('body')
</div>

<script src="{{elixir('js/all.js')}}"></script>
</body>
</html>