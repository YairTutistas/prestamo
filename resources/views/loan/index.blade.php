@extends('welcome')

@section('title', 'Loans')

@section('content_header')
    <h1>{{__('Loans')}}</h1>
@stop

@section('content')
<div class="">
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
                {{-- <th>{{__('Start date')}}</th> --}}
                <th>{{__('Days in arrears')}}</th>
                @can('updateLoan')
                    <th></th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentPlans as $paymentPlan)
                @php
                    $loan = $paymentPlan->loan;
                    $daysInArrears = $paymentPlan->daysInArrears ?? 0;
                @endphp
                <tr>
                    <th>{{$loan->id}}</th>
                    <th>{{$loan->portafolio->name}}</th>
                    <th><a href="{{ route("showClient", Crypt::encryptString($loan->client->id)) }}">{{$loan->client->name}}</a></th>
                    <th>@moneyformat($loan->amount)</th>
                    <th>{{$loan->interest_rate}} %</th>
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
                    <th>@moneyformat($loan->quota_value)</th>
                    <th class="text-success">@moneyformat($loan->total_pay)</th>
                    {{-- <th>{{$loan->start_date}}</th> --}}
                    <td>{{ $daysInArrears }}</td>
                    @can('updateLoan')
                        <th>
                            <div class="row">
                                <form action="{{ route('deleteLoan', Crypt::encryptString($loan->id)) }}" method="POST" id="delete-form-{{ $loan->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-danger btn-delete mr-1" data-id="{{ $loan->id }}" form="delete-form-{{ $loan->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <a href="{{route('showLoan', Crypt::encryptString($loan->id))}}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </th>
                    @endcan
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