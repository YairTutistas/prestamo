@extends('welcome')
@section('title', 'Create portafolio')

@section('content_header')
    <h1>{{__('Create portafolio')}}</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('savePortafolio')}}" method="POST">
            @csrf
            <div class="col-md-12 mt-3">
                <label for="name">{{__('Name')}}</label>
                <input type="text" name="name" id="name" placeholder="Name" class="form-control" required>
            </div>
            <div class="col-md-12 mt-3">
                <label for="userRol">{{__('User')}}</label>
                <select name="user_rol" class="form-control" id="userRol">
                    @foreach ($userRol as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary col-md-12 mt-5">{{__('Create')}}</button>
        </form>
    </div>
@stop