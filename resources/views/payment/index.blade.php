@extends('welcome')

@section('title', 'Payments')

@section('content_header')
    <h1>Payments</h1>
@stop

@section('content')
<div class="container">
    <div class="col-12 d-flex justify-content-end">
        <a href="{{route('createPayment')}}" class="btn btn-secondary mb-5">{{__('Crear')}}</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('loan')}}</th>
                <th>{{__('amount')}}</th>
                <th>{{__('payment_date')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <th>{{$payment->loan->client->name}}</th>
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
        $('#example').DataTable();
    });
    </script>
@endpush