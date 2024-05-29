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
                <input type="text" name="loan[quota_value]" class="form-control" id="quotaValue" required
                    placeholder="$10.000" readonly>
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
                <label for="endDate">{{ __('End date') }}</label>
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

    <script src="{{ asset('js/bundle.js') }}"></script>
    <script>
        // la varable SPECIAL_DATES contiene la libreria de dias especiales

        $(document).ready(function() {
            $('#client').select2();
        });

        let payment_method = {
            1: 1,
            2: 7,
            3: 15,
            4: 30
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
            if (paymentMethod != 4) {
                for (let index = 1; index <= deadlines; index++) {
                    if(index !== 1){
                        startDate = addDays(startDate, payment_method[paymentMethod]);
                        startDate = consultHolidays(startDate);
                    }

                    html += `<tr>`;
                    html += `<td>`;
                    html += `${index}`;
                    html += `<input name="payment_plan[${index}][quota]" value="${index}" type="hidden" />`;
                    html += `</td>`;
                    html += `<td>`;
                    html += `${quotaValue.value}`;
                    html += `<input name="payment_plan[${index}][indivudual_value]" value="${limpiador(quotaValue.value)}" type="hidden" />`;
                    html += `</td>`;
                    html += `<td>`;
                    html += `${startDate}`;
                    html += `<input name="payment_plan[${index}][payment_date]" value="${startDate}" type="hidden" />`;
                    html += `</td>`;
                    html += `</tr>`;
                }
                endDate.value = startDate;

            }else{
                startDate = startDate.split("-");
                dates_month = generarFechasDePago(startDate[2], startDate[1], startDate[0], deadlines);
                dates_month[0] = startDate.join("-");
                dates_month.forEach((element, index) => {
                    element = addDays(element, 0);
                    // console.log(element)
                    element = consultHolidays(element)
                    
                    // if(SPECIAL_DATES.isHoliday(new Date(element[0], element[1], element[2]))){
                    //     // do the magic here 7u7h
                    // }

                    html += `<tr>`;
                    html += `<td>`;
                    html += `${index +1}`;
                    html += `<input name="payment_plan[${index +1}][quota]" value="${index +1}" type="hidden" />`;
                    html += `</td>`;
                    html += `<td>`;
                    html += `${quotaValue.value}`;
                    html += `<input name="payment_plan[${index +1}][indivudual_value]" value="${limpiador(quotaValue.value)}" type="hidden" />`;
                    html += `</td>`;
                    html += `<td>`;
                    html += `${element}`;
                    html += `<input name="payment_plan[${index +1}][payment_date]" value="${element}" type="hidden" />`;
                    html += `</td>`;
                    html += `</tr>`;
                });
                endDate.value = dates_month[dates_month.length -1];
            }

            table_body.innerHTML = html;
        }

        function consultHolidays(data) {
            date_ok = data;
            data = data.split("-");
            responseHoliday = SPECIAL_DATES.isHoliday(new Date(data[0], data[1] - 1, data[2]));
            if (responseHoliday === true) {
                let day = (Number(data[2]) + 1);
                day = (day > 9) ? day : "0"+ day;
                
                date_ok = data[0] + "-" + data[1] + "-" + day;
                date_ok = consultHolidays(date_ok)
            } 
            return date_ok;
        }

        // Function to Add days to current date
        function addDays(date, days) {
            date = date.split('-');
            let newDate = new Date(date[0], date[1] - 1, date[2]);
            let date_real = new Date(newDate.setDate(newDate.getDate() + days));

            if(date_real.getDay() === 0){
                date_real = new Date(date_real.getFullYear(), date_real.getMonth(), date_real.getDate() +1);
            }

            return date_real.toISOString().split('T')[0];
        }

        function generarFechasDePago(diaDePago, mesInicial, anioInicial, cantidadPagos) {
            const fechasDePago = [];
            let mes = mesInicial - 1; // En JavaScript, los meses van de 0 (enero) a 11 (diciembre)
            let anio = anioInicial;

            for (let i = 0; i < cantidadPagos; i++) {
                let fechaPago;

                if (diaDePago > 30) {
                    diaDePago = 30; // Ajustamos el día de pago si es mayor a 30
                }

                // Obtenemos el último día del mes actual
                let ultimoDiaDelMes = new Date(anio, mes + 1, 0).getDate();

                if (diaDePago > ultimoDiaDelMes) {
                    // Si el día de pago no existe en el mes actual, lo movemos al primero del mes siguiente
                    fechaPago = new Date(anio, mes + 1, 1);
                } else {
                    // Si el día de pago existe en el mes actual
                    fechaPago = new Date(anio, mes, diaDePago);
                }

                fechasDePago.push(fechaPago);

                // Avanzamos al siguiente mes
                mes++;
                if (mes > 11) {
                    mes = 0;
                    anio++;
                }
            }

            return fechasDePago.map(fecha => fecha.toISOString().split('T')[0]); // Convertimos a formato YYYY-MM-DD
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
