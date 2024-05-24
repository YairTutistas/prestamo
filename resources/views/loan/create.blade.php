@extends('welcome')
@section('title', 'Create loan')

@section('content_header')
    <h1>{{__('Create loan')}}</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{route('saveLoan')}}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-12 mb-3">
                <label for="portafolio">{{__('Portafolio')}}</label>
                <select name="portafolio_id" id="portafolio" class="form-control" required>
                    @foreach ($portafolios as $portafolio)
                        <option value="{{$portafolio->id}}">{{$portafolio->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mb-3">
                    <label for="client">{{ __('Client') }}</label>
                    <select name="client_id" id="client" class="form-control" required>
                        @foreach ($clients as $client)
                        <option value="{{$client->id}}">{{$client->name}}</option>
                        @endforeach
                    </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="amount">{{__('Amount')}}</label>
                <input type="number" name="amount" id="amount" class="form-control" required placeholder="$10.000">
            </div>
            <div class="col-md-6 mb-3">
                <label for="interestRate">{{('Interest rate')}}</label>
                <input type="number" name="interest_rate" class="form-control" id="interestRate" required placeholder="10 %">
            </div>
            <div class="col-md-12 mb-3">
                <label for="deadlines">{{('Deadlines')}}</label>
                <input type="number" name="deadlines" class="form-control" required placeholder="10" id="deadlines">
            </div>
            <div class="col-md-12 mb-3">
                <label for="quotaValue">{{('Quota value')}}</label>
                <input type="number" name="quota_value" class="form-control" id="quotaValue" required placeholder="$10.000">
            </div>
            <div class="col-md-12 mb-3">
                <label for="paymentMethod">{{('Payment method')}}</label>
                <select name="payment_method" id="paymentMethod" class="form-control">
                    <option value="1">Diario</option>
                    <option value="2">Semanal</option>
                    <option value="3">Quincenal</option>
                    <option value="4">Mensual</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="startDate">{{('Start date')}}</label>
                <input type="date" name="start_date" class="form-control" id="startDate">
            </div>
            <div class="col-md-6 mb-5">
                <label for="endDate">{{__('End date')}}</label>
                <input type="date" name="end_date" class="form-control" id="endDate">
            </div>
            <button class="btn btn-primary form-control">{{__('Save')}}</button>
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