@extends('welcome')

@section('title', 'Profile')
@section('content_header')
@stop
    
@section('content')
    <h1>Profile</h1>
    <main>
        {{ $slot }}
    </main>
@stop