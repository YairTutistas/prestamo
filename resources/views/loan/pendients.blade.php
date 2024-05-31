@extends('welcome')

@section('title', 'Loans')

@section('content_header')
    <h1>{{__('Loans')}}</h1>
@stop

@section('content')
<div class="container">
    <div class="col-12 d-flex justify-content-end">
        <a href="{{route('createLoan')}}" class="btn btn-secondary mb-5">{{__('Create')}}</a>
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
                <th>{{__('Portafolio')}}</th>
                <th>{{__('Client')}}</th>
                <th>{{__('Amount')}}</th>
                <th>{{__('Interest rate')}}</th>
                <th>{{__('Deadlines')}}</th>
                <th>{{__('Payment method')}}</th>
                <th>{{__('Quota value')}}</th>
                <th>{{__('Total to pay')}}</th>
                <th>{{__('Start date')}}</th>
                <th></th>
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
                    <th>
                        <a href="{{route('approveLoan', Crypt::encryptString($loan->id))}}" class="btn btn-success">{{__('Approve')}}</a>
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
        const ACTIVATE_NOTIFICATIONS = true;
        $(document).ready(function() {
            $('#loans').DataTable();

            if(ACTIVATE_NOTIFICATIONS){
                document.querySelector("#payment_menu_id").children[0].children[1].children[0].innerHTML = '{{ $loans->count() }}';
                setInterval(() => {
                    fetch('{{ route("pendientCounter") }}').then(function(response){
                        return response.json();
                    }).then(function(data) {
                        document.querySelector("#payment_menu_id").children[0].children[1].children[0].innerHTML = data;
                    });
                }, 10_000);
            }
        });
    </script>
@endpush