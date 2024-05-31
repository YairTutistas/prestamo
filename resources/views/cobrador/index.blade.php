@extends('welcome')

@section('title', 'Loans by clients')

@section('content_header')
    <h1>{{__('Loans by clients')}}</h1>
@stop

@section('content')
<div class="container">
    <div class="table-responsive">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table id="loans" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>{{__('#')}}</th>
                    <th>{{__('Portafolio')}}</th>
                    <th>{{__('Client')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Interest rate')}}</th>
                    <th>{{__('Deadlines')}}</th>
                    <th>{{__('Payment method')}}</th>
                    <th>{{__('Quota value')}}</th>
                    <th>{{__('Total to pay')}}</th>
                    <th>{{__('Start date')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                    <tr>
                        <th>{{$loan->id}}</th>
                        <th>{{$loan->portafolio->name}}</th>
                        <th>{{$loan->client->name}}</th>
                        <th>{{$loan->amount}}</th>
                        <th>{{$loan->interest_rate}}</th>
                        <th>{{$loan->deadlines}}</th>
                        @switch($loan->payment_method)
                            @case(1)
                                <th>Diario</th>
                                @break
                            @case(2)
                                <th>Semanal</th>
                                @break
                            @case(3)
                                <th>Quincenal</th>
                                @break
                            @case(4)
                                <th>Mensual</th>
                                @break
                            @default
                            <th>Null</th>
                        @endswitch
                        <th>{{$loan->quota_value}}</th>
                        <th class="text-success">{{$loan->total_pay}}</th>
                        <th>{{$loan->start_date}}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
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