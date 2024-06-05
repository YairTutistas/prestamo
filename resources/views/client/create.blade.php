@extends('welcome')

@section('title', 'Create client')

@section('content_header')
    <h1>{{__('Create client')}}</h1>
@stop

@section('content')
<div class="container">
    <form action="{{route('saveClient')}}" method="POST">
      @csrf
        <div class="mt-3">
          <label for="name" class="form-label">{{__('Name')}}</label>
          <input type="text" name="name" class="form-control" id="name" placeholder="Jeremias Portlen" required>
        </div>
        <div class="mt-3">
          <label for="typeDocument" class="form-label">{{__('Type document')}}</label>
          <select type="text" name="type_document" class="form-control" id="typeDocument" required>
            <option value="">{{__('Select...')}}</option>
            <option value="Cedula ciudadania">{{__('Cedula ciudadanía')}}</option>
            <option value="Tarjeta identidad">{{__('Tarjeta identidad')}}</option>
            <option value="Cedula extranjeria">{{__('Cedula extranjería')}}</option>
            <option value="Pasaporte">{{__('Pasaporte')}}</option>
          </select>
        </div>
        <div class="mt-3">
          <label for="document" class="form-label">{{__('Document')}}</label>
          <input type="text" name="document" class="form-control" id="Document" placeholder="15563655665" required>
        </div>
        <div class="mt-3">
          <label for="phone" class="form-label">{{__('Phone')}}</label>
          <input type="number" name="phone" class="form-control" id="phone" placeholder="123456789" required>
        </div>
        <div class="mt-3">
          <label for="email" class="form-label">{{__('Email')}}</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="example@example.com">
        </div>
        <div class="mt-3">
          <label for="Address" class="form-label">{{__('Addresses')}}</label>
          <input type="text" name="addresses" class="form-control" name="addresses" id="Address" required>
        </div>
        <div class="mt-3">
          <label for="inputCity" class="form-label">{{__('City')}}</label>
          <input type="text" name="city" class="form-control" id="inputCity">
        </div>
        <div class="mt-3">
          <label for="neigborhood" class="form-label">{{__('Neigborhood')}}</label>
          <input type="text" name="neigborhood" class="form-control" id="neigborhood">
        </div>
        <div class="mt-3">
          <label for="company">{{__('Company')}}</label>
          <select name="company_id" id="company" class="form-control">
            <option value="">{{__('Select...')}}</option>
            @foreach ($companys as $company)
                <option value="{{Crypt::encryptString($company->id)}}">{{$company->name}}</option>
            @endforeach
          </select>
        </div>
        <button class="btn btn-primary form-control mt-3">{{__('Save')}}</button>
    </form>
</div>
@stop