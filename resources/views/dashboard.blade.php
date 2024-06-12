@extends('welcome')
@section('title', 'Dashboard Administración')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    @foreach ($portafolios as $portafolio)
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>@moneyformat(150000)</h3>
                    <p>{{$portafolio->name}}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-folder"></i>
                </div>
                <a href="/loans" class="small-box-footer">More info <i class="fas fa-folder"></i></a>
            </div>
        </div>
    @endforeach
</div>
    <div class="row">
        <!-- Online Store Visitors -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Amount of payments per day</div>
                <div class="card-body">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Sales -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Payments</div>
                <div class="card-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Loans per days</div>
            <div class="card-body">
                <canvas id="loans"></canvas>
            </div>
        </div>
    </div>
    {{-- @dd($loanSuccess) --}}

    {{-- <div class="row">
        <!-- Online Store Overview -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Online Store Overview</div>
                <div class="card-body">
                    <!-- Resumen de la tienda -->
                    <p>Conversion Rate: {{ $storeOverview['conversion_rate'] }}</p>
                    <p>Sales Rate: {{ $storeOverview['sales_rate'] }}</p>
                    <p>Registration Rate: {{ $storeOverview['registration_rate'] }}</p>
                </div>
            </div>
        </div>
    </div> --}}
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesData = @json($salesData);
        const todayPaymentsCount = @json($todayPaymentsCount);
        const loanSuccess = @json($loanSuccess);
        // console.log(loanSuccess)

        // Gráfico de prestamos
        const loansCtx = document.getElementById('loans').getContext('2d');
        const loanChart = new Chart(loansCtx, {
            type: 'line',
            data: {
                labels: Object.keys(loanSuccess),
                datasets: [{
                    label: 'Loans by day',
                    data: Object.values(loanSuccess),
                    borderColor: 'green',
                    // backgroundColor: 'lightblue',
                    fill: false
                }]
            }
        });
        // Gráfico de visitantes
        const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
        const visitorsChart = new Chart(visitorsCtx, {
            type: 'line',
            data: {
                labels: Object.keys(todayPaymentsCount),
                datasets: [{
                    label: 'Amount of payments per day',
                    data: Object.values(todayPaymentsCount),
                    borderColor: 'blue',
                    backgroundColor: 'lightblue',
                    fill: false
                }]
            }
        });

        // Gráfico de ventas
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(salesData),
                datasets: [{
                    label: 'Payments',
                    data: Object.values(salesData),
                    backgroundColor: 'blue'
                }]
            }
        });
    </script>
@stop