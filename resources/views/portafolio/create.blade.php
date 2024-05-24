@extends('welcome')
@section('title', 'Create portafolio')

@section('content_header')
    <h1>{{__('Create portafolio')}}</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('savePortafolio')}}" method="POST">
            @csrf
            <div class="col-md-12 mb-3">
                <label for="name">{{__('Name')}}</label>
                <input type="text" name="name" id="name" placeholder="Name" class="form-control" required>
            </div>
            <button class="btn btn-primary form-control">{{__('Create')}}</button>
        </form>
    </div>
@stop