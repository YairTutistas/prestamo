@extends('welcome')

@section('title', 'Detail client')

@section('content_header')
    <h1>{{__('Detail client')}}</h1>
@stop

@section('content')
<div class="col-12 d-flex justify-content-end">
    <a href="{{route('loansClient', $client)}}" type="button" class="btn btn-link">{{__('Show loans')}}</a>
</div>
<div class="container">
    <form action="{{route('updateClient', $client->id)}}" method="POST" class="row g-3">
      @csrf
        <div class="mb-3 col-md-12">
          <label for="name" class="form-label">{{__('Name')}}</label>
          <input type="text" name="name" class="form-control" id="name" value="{{$client->name}}" required>
        </div>
        <div class="mb-3 col-md-6">
            <label for="typeDocument" class="form-label">{{ __('Type document') }}</label>
            <select name="type_document" id="typeDocument" class="form-control" required>
                <option value="">{{ __('Select a type') }}</option>
                <option value="Cedula ciudadania" {{ $client->type_document == 'Cedula ciudadania' ? 'selected' : '' }}>
                    {{ __('Cedula ciudadanía') }}
                </option>
                <option value="Tarjeta identidad" {{ $client->type_document == 'Tarjeta identidad' ? 'selected' : '' }}>
                    {{ __('Tarjeta identidad') }}
                </option>
                <option value="Cedula extranjeria" {{ $client->type_document == 'Cedula extranjeria' ? 'selected' : '' }}>
                    {{ __('Cedula extranjería') }}
                </option>
                <option value="Pasaporte" {{ $client->type_document == 'Pasaporte' ? 'selected' : '' }}>
                    {{ __('Pasaporte') }}
                </option>
            </select>
        </div>
        <div class="mb-3 col-md-6">
          <label for="document" class="form-label">{{__('Document')}}</label>
          <input type="text" name="document" class="form-control" id="Document" value="{{$client->document}}" required>
        </div>
        <div class="mb-3 col-md-6">
          <label for="phone" class="form-label">{{__('Phone')}}</label>
          <input type="number" name="phone" class="form-control" id="phone" value="{{$client->phone}}" required>
        </div>
        <div class="mb-3 col-md-6">
          <label for="email" class="form-label">{{__('Email')}}</label>
          <input type="email" name="email" class="form-control" id="email" value="{{$client->email}}">
        </div>
        <div class="mb-3 col-md-4">
          <label for="Address" class="form-label">{{__('Addresses')}}</label>
          <input type="text" name="addresses" class="form-control" name="addresses" id="Address" value="{{$client->addresses}}">
        </div>
        <div class="mb-3 col-md-4">
          <label for="inputCity" class="form-label">{{__('City')}}</label>
          <input type="text" name="city" class="form-control" id="inputCity" value="{{$client->city}}">
        </div>
        <div class="mb-5 col-md-4">
          <label for="neigborhood" class="form-label">{{__('Neigborhood')}}</label>
          <input type="text" name="neigborhood" class="form-control" id="neigborhood" value="{{$client->neigborhood}}">
        </div>
        <button class="btn btn-primary form-control">{{__('Actualizar')}}</button>
    </form>
    <hr>
    <h3>{{__('payment information')}}</h3>    
    <table id="payments" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('#')}}</th>
                <th>{{__('Loan')}}</th>
                <th>{{__('amount')}}</th>
                <th>{{__('payment_date')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <th>{{$payment->id}}</th>
                    <th>{{$payment->loanName}}</th>
                    <th>{{$payment->amount}}</th>
                    <th>{{$payment->payment_date}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
@push('styles')
    <!-- DataTables CSS -->
    <link href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Initialize DataTables -->
    <script>
    $(document).ready(function() {
        $('#payments').DataTable();
    });
    </script>
@endpush