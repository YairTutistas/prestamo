@extends('welcome')

@section('title', 'Companys')

@section('content_header')
    <h1>{{__('Companys')}}</h1>
@stop

@section('content')
<div class="container">
    <div class="col-12 d-flex justify-content-end">
        <a href="{{route('createCompany')}}" class="btn btn-secondary mb-5">{{__('Create')}}</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <table id="company" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('Name')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <th>{{$company->name}}</th>
                    <th class="col-md-1">
                        <a target="_blank" class="btn btn-primary mr-1" href="{{ route("generateInvoice", Crypt::encryptString($company->id)) }}"><i class="fas fa-edit"></i></a>
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
        $('#company').DataTable();
    });
    </script>
@endpush