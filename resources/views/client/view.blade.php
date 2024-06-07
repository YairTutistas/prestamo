@extends('welcome')

@section('title', 'Detail client')

@section('content_header')
    <h1>{{ __('Detail client') }}</h1>
@stop

@section('content')
    <div class="col-12 d-flex justify-content-end">
        <a href="{{ route('loansClient', Crypt::encryptString($client->id)) }}" type="button" class="btn btn-link">{{ __('Show loans') }}</a>
    </div>
    <div class="container">
        <form action="{{ route('updateClient', Crypt::encryptString($client->id)) }}" method="POST" class="row g-3">
            @csrf
            <div class="mt-3 col-md-12">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $client->name }}"
                    required>
            </div>
            <div class="mt-3 col-md-6">
                <label for="typeDocument" class="form-label">{{ __('Type document') }}</label>
                <select name="type_document" id="typeDocument" class="form-control" required>
                    <option value="">{{ __('Select a type') }}</option>
                    <option value="Cedula ciudadania" {{ $client->type_document == 'Cedula ciudadania' ? 'selected' : '' }}>
                        {{ __('Cedula ciudadanía') }}
                    </option>
                    <option value="Tarjeta identidad"
                        {{ $client->type_document == 'Tarjeta identidad' ? 'selected' : '' }}>
                        {{ __('Tarjeta identidad') }}
                    </option>
                    <option value="Cedula extranjeria"
                        {{ $client->type_document == 'Cedula extranjeria' ? 'selected' : '' }}>
                        {{ __('Cedula extranjería') }}
                    </option>
                    <option value="Pasaporte" {{ $client->type_document == 'Pasaporte' ? 'selected' : '' }}>
                        {{ __('Pasaporte') }}
                    </option>
                </select>
            </div>
            <div class="mt-3 col-md-6">
                <label for="document" class="form-label">{{ __('Document') }}</label>
                <input type="text" name="document" class="form-control" id="Document" value="{{ $client->document }}"
                    required>
            </div>
            <div class="mt-3 col-md-6">
                <label for="phone" class="form-label">{{ __('Phone') }}</label>
                <input type="text" name="phone" class="form-control" id="phone" value="{{ $client->phone }}"
                    required>
            </div>
            <div class="mt-3 col-md-6">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $client->email }}">
            </div>
            <div class="mt-3 col-md-4">
                <label for="Address" class="form-label">{{ __('Addresses') }}</label>
                <input type="text" name="addresses" class="form-control" name="addresses" id="Address"
                    value="{{ $client->addresses }}">
            </div>
            <div class="mt-3 col-md-4">
                <label for="inputCity" class="form-label">{{ __('City') }}</label>
                <input type="text" name="city" class="form-control" id="inputCity" value="{{ $client->city }}">
            </div>
            <div class="mt-3 col-md-4">
                <label for="neigborhood" class="form-label">{{ __('Neigborhood') }}</label>
                <input type="text" name="neigborhood" class="form-control" id="neigborhood"
                    value="{{ $client->neigborhood }}">
            </div>
            <div class="mt-3 col-md-12">
                <label for="company">Company</label>
                <select name="company_id" id="company" class="form-control">
                    @foreach ($companys as $company)
                    <option value="{{Crypt::encryptString($company->id)}}" {{ $company->id == $client->company_id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary form-control mt-3">{{ __('Update') }}</button>
        </form>
        <hr>
        <h3>{{ __('payment information') }}</h3>
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <span class="info-box-text" id="info_loan_id">0</span>
                <span class="info-box-number" id="info_totals">0</span>
                <div class="progress">
                    <div class="progress-bar bg-info" id="info_percent"></div>
                </div>
                <span class="progress-description" id="info_percent_number">0%</span>
            </div>
        </div>


        <div class="table-responsive">
            <table id="payments" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('Loan #') }}</th>
                        <th>{{ __('Payment date') }}</th>
                        {{-- <th>{{ __('Payment type') }}</th> --}}
                        <th>{{ __('Amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr title="{{ __('Total payment: ') . '(' . $payment->getTotalPayments() . '/' . $payment->total_pay . ')' }}"
                            data-loan_id="{{ $payment->id }}"
                            data-payment="{{ $payment->getTotalPayments() }}"
                            data-loan="{{ $payment->total_pay }}"
                            onmouseover="calculate_info(this)"
                            style="cursor: pointer;"
                        >
                            <th>{{ $payment->id }}</th>
                            <th>{{ $payment->payment_date }}</th>
                            {{-- <th>{{ $payment->paymentType->name }}</th> --}}
                            <th>{{ $payment->amount }}</th>
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
            $('#payments').DataTable();
        });

        function calculate_info(element)
        {
            let data = element.dataset;
            console.log(data);
            document.querySelector("#info_loan_id").textContent = "Loan # " + data.loan_id;
            document.querySelector("#info_totals").textContent = `(${data.payment}/${data.loan})`;
            document.querySelector("#info_percent").style.width = (data.payment * 100) / data.loan + "%";
            document.querySelector("#info_percent_number").textContent = (data.payment * 100) / data.loan + "%";
        }
    </script>
@endpush
