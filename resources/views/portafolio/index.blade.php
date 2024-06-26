@extends('welcome')

@section('title', 'Portafolios')

@section('content_header')
    <h1>{{__('Portafolios')}}</h1>
@stop

@section('content')
<div class="container">
    <div class="col-12 d-flex justify-content-end">
        <a href="{{route('createPortafolio')}}" class="btn btn-secondary mb-5">{{__('Create')}}</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <table id="loans" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('#')}}</th>
                <th>{{__('Name')}}</th>
                <th>{{__('Debt collector')}}</th>
                <th>{{__('Company')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($portafolios as $portafolio)
                <tr>
                    <th>{{$portafolio->id}}</th>
                    <th>{{$portafolio->name}}</th>
                    <th>{{$portafolio->getDebtCollector->name}}</th>
                    <th>{{$portafolio->company->name}}</th>
                    <th>
                        <a href="{{route('showPortafolio', Crypt::encryptString($portafolio->id))}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
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
        $('#loans').DataTable();
    });
    </script>
@endpush