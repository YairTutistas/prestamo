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
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loansClient as $loanclient)
                <tr>
                    <th>
                        <a href="{{route('showLoanClient',Crypt::encryptString($loanclient->id))}}">
                            {{$loanclient->id}}
                        </a>
                    </th>
                    <th>{{$loanclient->portafolio->name}}</th>
                    <th>{{$loanclient->client->name}}</th>
                    <th>{{$loanclient->amount}}</th>
                    <th>{{$loanclient->interest_rate}}</th>
                    <th>{{$loanclient->deadlines}}</th>
                    <th>{{$loanclient->quota_value}}</th>
                    <th>{{$loanclient->getValidatePaymethod($loanclient->payment_method)}}</th>
                    <th>{{$loanclient->start_date}}</th>
                    <th>{{$loanclient->end_date}}</th>
                    <td> 
                        @if ($loanclient->status == 2)
                            <i title="Finished" class="fas fa-check-circle text-success"></i>
                        
                        @else
                            <i title="Peding" class="fas fa-hand-holding-usd text-warning"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="container mt-5">
    <h3>{{__('Payment plans')}}</h3>
    <table id="paymentPlan" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('Quota')}}</th>
                <th>{{__('Value')}}</th>
                <th>{{__('Payment date')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentPlans as $paymentPlan)
                <tr>
                    <th>{{$paymentPlan->quota}}</th>
                    <th>@moneyformat($paymentPlan->indivudual_value)</th>
                    <th>{{$paymentPlan->payment_date}}</th>
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
    <script>
    $(document).ready(function() {
        $('#paymentPlan').DataTable();
    });
    </script>
@endpush