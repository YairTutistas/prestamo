@extends('welcome')

@section('title', 'Payments')

@section('content_header')
    <h1>{{__('Payments')}}</h1>
@stop

@section('content')
<div class="container">
    <div class="col-12 d-flex justify-content-end">
        <a href="{{route('createPayment')}}" class="btn btn-secondary mb-5">{{__('Create')}}</a>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{__('Loan')}}</th>
                <th>{{__('Amount')}}</th>
                <th>{{__('Payment type')}}</th>
                <th>{{__('Payment date')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <th>{{$payment->loan->client->name}}</th>
                    <th>@moneyformat($payment->amount)</th>
                    <th>{{$payment->paymentType->name}}</th>
                    <th>{{$payment->payment_date}}</th>
                    <th>
                        <div class="row">
                            @can('deletePayment')
                            <form action="{{ route('deletePayment', Crypt::encryptString($payment->id)) }}" method="POST" id="delete-form-{{ $payment->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="submit" class="btn btn-danger mr-1" data-id="{{ $payment->id }}" form="delete-form-{{ $payment->id }}"><i class="fas fa-trash-alt"></i></button>
                            @endcan
                            <a target="_blank" class="btn btn-warning mr-1" href="{{ route("generateInvoice", Crypt::encryptString($payment->id)) }}"><i class="fas fa-file-pdf"></i></a>
                        </div>
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
        $('#example').DataTable();
    });
    </script>
@endpush