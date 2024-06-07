@extends('welcome')
@section('title', 'Create payment')

@section('content_header')
    <h1>{{__('Create payment')}}</h1>
@stop
{{-- @dd($paymentTypes) --}}
@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{route('savePayment')}}" method="POST" class="mt-5">
            @csrf
            <div class="col-md-12 mb-3">
                <label for="client">{{ __('Client') }}</label>
                <select name="loan_id" id="client" class="form-control" required>
                    @foreach ($loans as $loan)
                        <option value="{{Crypt::encryptString($loan->id)}}">{{$loan->client->name ." - ". $loan->id ." (". $loan->total_pay .")"}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label for="paymentType">{{ __('Payment types') }}</label>
                <select name="paymentType_id" id="paymentType" class="form-control" required>
                    @foreach ($paymentTypes as $paymentType)
                        <option value="{{Crypt::encryptString($paymentType->id)}}">{{$paymentType->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mb-3">
                <label for="amount">{{__('Amount')}}</label>
                <input type="number" class="form-control" name="amount" placeholder="$10.000" required>
            </div>
            <div class="col-md-12 mb-5">
                <label for="paymentDate">{{__('Payment date')}}</label>
                <input type="date" class="form-control" id="paymentDate" name="payment_date" max="{{ now()->format('Y-m-d') }}" required>
            </div>
            <button class="btn btn-primary form-control">{{__('Create')}}</button>
        </form>

    </div>
@stop
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('#client').select2();
        });
    </script>
@endpush