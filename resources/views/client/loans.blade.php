@extends('welcome')

@section('title', 'Loans clients')

@section('content_header')
    <h1>{{__('Loans client')}}</h1>
@stop

@section('content')
<div class="container">
    <table id="clients" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('#')}}</th>
                <th>{{__('Portafolio')}}</th>
                <th>{{__('Client')}}</th>
                <th>{{__('Amount')}}</th>
                <th>{{__('Interest rate')}}</th>
                <th>{{__('Deadlines')}}</th>
                <th>{{__('Quota value')}}</th>
                <th>{{__('Payment method')}}</th>
                <th>{{__('Start date')}}</th>
                <th>{{__('End date')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loansClient as $loanclient)
                <tr>
                    <th>{{$loanclient->id}}</th>
                    <th>{{$loanclient->portafolio->name}}</th>
                    <th>{{$loanclient->client->name}}</th>
                    <th>{{$loanclient->amount}}</th>
                    <th>{{$loanclient->interest_rate}}</th>
                    <th>{{$loanclient->deadlines}}</th>
                    <th>{{$loanclient->quota_value}}</th>
                    <th>{{$loanclient->payment_method}}</th>
                    <th>{{$loanclient->start_date}}</th>
                    <th>{{$loanclient->end_date}}</th>
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