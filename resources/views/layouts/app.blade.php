@extends('welcome')

@section('title', 'Profile')
@section('content_header')
@stop
    
@section('content')
    {{ $header }}
    <main>
        {{ $slot }}
    </main>
@stop