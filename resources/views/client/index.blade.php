@extends('welcome')

@section('title', 'Clients')

@section('content_header')
    <h1>{{__('Clients')}}</h1>
@stop

@section('content')
<div class="container">
    <div class="col-12 d-flex justify-content-end">
        <a href="{{route('createClient')}}" class="btn btn-secondary mb-5">{{__('Crear')}}</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <table id="clients" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('Name')}}</th>
                <th>{{__('Type document')}}</th>
                <th>{{__('Document')}}</th>
                <th>{{__('Phone')}}</th>
                <th>{{__('Email')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <th>{{$client->name}}</th>
                    <th>{{$client->type_document}}</th>
                    <th>{{$client->document}}</th>
                    <th>{{$client->phone}}</th>
                    <th>{{$client->email}}</th>
                    <th>
                        <a href="{{route('showClient', Crypt::encryptString($client->id))}}" class="btn btn-primary">{{__('Details')}}</a>
                        <a href="{{route('deleteClient', Crypt::encryptString($client->id))}}" class="btn btn-danger">{{__('Delete')}}</a>
                    </th>
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
        $('#clients').DataTable();
    });
    </script>
@endpush