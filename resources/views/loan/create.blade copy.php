@extends('welcome')
@section('title', 'Create loan')

@section('content_header')
    <h1>{{ __('Create loan') }}</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('saveLoan') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-12">
                <label for="portafolio">{{ __('Portafolio') }}</label>
                <select name="loan[portafolio_id]" id="portafolio" class="form-control" required>
                    @foreach ($portafolios as $portafolio)
                        <option value="{{ $portafolio->id }}">{{ $portafolio->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mt-3">
                <label for="client">{{ __('Client') }}</label>
                <select name="loan[client_id]" id="client" class="form-control" required>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mt-3">
                <label for="amount">{{ __('Amount') }}</label>
                <input type="text" name="loan[amount]" id="amount" class="form-control" required placeholder="$10.000"
                    oninput="createPayment(); currencyFormatter(this)">
            </div>
            <div class="col-md-6 mt-3">
                <label for="deadlines">{{ 'Deadlines' }} (MAX: 48)</label>
                <input type="number" placeholder="10" class="form-control" name="loan[deadlines]" id="deadlines"
                    oninput="createPayment()" required>
            </div>
            <div class="col-md-6 mt-3">
                <label for="interestRate">{{ 'Interest rate' }}</label>
                <input type="number" name="loan[interest_rate]" class="form-control" id="interestRate" required
                    placeholder="10 %" oninput="createPayment()">
            </div>
            <div class="col-md-6 mt-3">
                <label for="quotaValue">{{ 'Quota value' }}</label>
                <input type="text" name="loan[quota_value]" class="form-control" id="quotaValue" required placeholder="$10.000"
                    readonly>
            </div>
            <div class="col-md-12 mt-3">
                <label for="paymentMethod">{{ 'Payment method' }}</label>
                <select name="loan[payment_method]" id="paymentMethod" class="form-control" onchange="createPayment()">
                    <option value="1">Diario</option>
                    <option value="2">Semanal</option>
                    <option value="3">Quincenal</option>
                    <option value="4">Mensual</option>
                </select>
            </div>
            <div class="col-md-4 mt-3">
                <label for="startDate">{{ 'Start date' }}</label>
                <input type="date" name="loan[start_date]" class="form-control" id="startDate" oninput="createPayment()">
            </div>
            <div class="col-md-4 mt-3">
                <label for="endDate">{{__('End date')}}</label>
                <input type="date" name="loan[end_date]" class="form-control" id="endDate" readonly>
            </div>
            <div class="col-md-4 mt-3">
                <button id="save" class="btn btn-primary form-control mt-8">{{ __('Save') }}</button>
            </div>
            
            <div class="col-md-12 mt-4" style="overflow: auto; max-height: 250px">
                <table class="table table-striped">
                    <thead class="bg-light sticky-top top-0">
                        <th>#</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </thead>
                    <tbody id="table_payment_body" style="overflow: auto; max-height: 250px">

                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script src="{{ asset("js/bundle.js") }}"></script>
    <script>
        // la varable holidays contiene la libreria de dias especiales

        $(document).ready(function() {
            $('#client').select2();
        });

        let payment_method = {
            1:1,
            2:7,
            3:15,
            4:30
        }

        let BY_MONTH = false;
        function createPayment() {
            let table_body = document.querySelector('#table_payment_body');
            let paymentMethod = document.querySelector('#paymentMethod').value;
            let startDate = document.querySelector('#startDate').value;
            let endDate = document.querySelector('#endDate');

            let amount = limpiador(document.querySelector('#amount').value);
            let interestRate = document.querySelector('#interestRate').value;
            let deadlines = document.querySelector('#deadlines').value;
            let quotaValue = document.querySelector('#quotaValue');

            table_body.innerHTML = "";
            quotaValue.value = "";

            if (amount === "" || amount == 0) {
                // alert('Ingrese un valor monetario');
                return false;
            }

            if (interestRate === "" || interestRate == 0) {
                // alert('Ingrese un porcentaje de interes');
                return false;
            }

            if (deadlines === "" || deadlines <= 0 || deadlines > 48) {
                // alert('Ingrese una cantidad de cuotas');
                return false;
            }

            if (startDate === "") {
                // alert('Ingrese una fecha de inicio');
                return false;
            }

            quotaValue.value = formatterValor.format((((amount * interestRate) / 100) + Number(amount)) / deadlines);

            let html = "";
            startDate = addDays(startDate, 0);
            console.log(startDate);
            for (let index = 1; index <= deadlines; index++) {
                html += `<tr>`;
                html += `<td>`;
                html += `${index}`;
                html += `<input name="payment_plan[${index}][quota_number]" value="${index}" type="hidden" />`;
                html += `</td>`;
                html += `<td>`;
                html += `${quotaValue.value}`;
                html += `<input name="payment_plan[${index}][quota_value]" value="${limpiador(quotaValue.value)}" type="hidden" />`;
                html += `</td>`;
                html += `<td>`;
                html += `${startDate}`;
                html += `<input name="payment_plan[${index}][quota_date]" value="${startDate}" type="hidden" />`;
                html += `</td>`;
                html += `</tr>`;

                if(BY_MONTH){
                    if(paymentMethod != 4){
                        startDate = addDays(startDate, payment_method[paymentMethod]);
                    }else{
                        startDate = addDays(startDate, 1, true);
                    }
                }else{
                    startDate = addDays(startDate, payment_method[paymentMethod]);
                }
            }

            table_body.innerHTML = html;
            if(BY_MONTH){
                if(paymentMethod != 4){
                    endDate.value = addDays(startDate, -payment_method[paymentMethod]);
                }else{
                    endDate.value = addDays(startDate, -1, true);
                }
            }else{
                endDate.value = addDays(startDate, -payment_method[paymentMethod]);
            }
        }

        // Function to Add days to current date
        function addDays(date, days, month = false) {
            date = date.split('-');
            let newDate = new Date(date[0], date[1] - 1, date[2]);

            if(month){
                return new Date(newDate.setMonth(newDate.getMonth() + days)).toISOString().split('T')[0];
            }
            return new Date(newDate.setDate(newDate.getDate() + days)).toISOString().split('T')[0];
        }

        function limpiador(data) {
            return data.replace(/[^\d]/g, '');
        }

        const formatterValor = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0,
        });

        // Función para dar formato de moneda al valor en tiempo real
        function currencyFormatter(input) {
            var valor = input.value;
            valor = limpiador(valor);
            valor = formatterValor.format(valor);
            input.value = valor;
        }
    </script>
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
