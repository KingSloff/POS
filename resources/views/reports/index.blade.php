@extends('layouts.master')

@section('title', 'Reports')

@section('body')
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <td><strong>Name</strong></td>
        </tr>
        </thead>
        <tbody>
        <tr>
		    <td><a href="{{route('report.stats')}}">Stats</a></td>
		</tr>
        </tbody>
    </table>
</div>
@endsection