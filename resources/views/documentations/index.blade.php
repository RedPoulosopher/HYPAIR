@extends('layouts.app')

@section('title', 'Ok')

@section('content')
    @foreach ($documentations as $documentation)
        {{ $documentation }}<br>
    @endforeach
@endsection