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
                <label for="userRol">{{__('Debt collector')}}</label>
                <select name="debt_collector" class="form-control" id="debt_collector">
                    @foreach ($userRol as $user)
                        <option value="{{Crypt::encryptString($user->id)}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mt-3">
                <label for="company">{{__('Company')}}</label>
                <select name="company_id" class="form-control" id="company">
                    @foreach ($companys as $company)
                        <option value="{{Crypt::encryptString($company->id)}}">{{$company->name}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary col-md-12 mt-3">{{__('Create')}}</button>
        </form>
    </div>
@stop