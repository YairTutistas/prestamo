@extends('adminlte::page')

@section('title', 'Dashboard Administración')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
@stack('styles')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Bienvenido al panel de administración de AdminLTE.</p>
@stop

@stack('scripts')
<!-- Include all JS -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/sweetAlert.js') }}" defer></script>
@stack('js')
