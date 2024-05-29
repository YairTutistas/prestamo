@extends('welcome')
@section('title', 'Edit loan')

@section('content_header')
    <h1>{{__('Edit loan')}}</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('updateLoan', Crypt::encryptString($loan->id))}}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-12 mb-3">
                <label for="portafolio">{{__('Portafolio')}}</label>
                <select name="portafolio_id" id="portafolio" class="form-control" required>
                    @foreach ($portafolios as $portafolio)
                        <option value="{{$portafolio->id}}" {{$loan->portafolio_id == $portafolio->id ? 'Selected' : '' }}>{{$portafolio->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mb-3">
                    <label for="client">{{ __('Client') }}</label>
                    <select name="client_id" id="client" class="form-control" required>
                        <option value="{{$loan->client_id}}">{{$loan->client->name}}</option>
                    </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="amount">{{__('Amount')}}</label>
                <input type="number" name="amount" id="amount" class="form-control" required value="{{$loan->amount}}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="interestRate">{{('Interest rate')}}</label>
                <input type="number" name="interest_rate" class="form-control" id="interestRate" required value="{{$loan->interest_rate}}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="deadlines">{{('Deadlines')}}</label>
                <input type="number" name="deadlines" class="form-control" required value="{{$loan->deadlines}}" id="deadlines">
            </div>
            <div class="col-md-12 mb-3">
                <label for="quotaValue">{{('Quota value')}}</label>
                <input type="number" name="quota_value" class="form-control" id="quotaValue" required value="{{$loan->quota_value}}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="paymentMethod">{{('Payment method')}}</label>
                <select name="payment_method" id="paymentMethod" class="form-control">
                    <option value="1" {{$loan->payment_method == '1' ? 'selected' : ''}}>Diario</option>
                    <option value="2" {{$loan->payment_method == '2' ? 'selected' : ''}}>Semanal</option>
                    <option value="3" {{$loan->payment_method == '3' ? 'selected' : ''}}>Quincenal</option>
                    <option value="4" {{$loan->payment_method == '4' ? 'selected' : ''}}>Mensual</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="startDate">{{('Start date')}}</label>
                <input type="date" name="start_date" class="form-control" id="startDate" value="{{$loan->start_date}}">
            </div>
            <div class="col-md-6 mb-5">
                <label for="endDate">{{__('End date')}}</label>
                <input type="date" name="end_date" class="form-control" id="endDate" value="{{$loan->end_date}}">
            </div>
            <button class="btn btn-primary form-control">{{__('Update')}}</button>
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