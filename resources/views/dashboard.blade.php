@extends('welcome')
@section('title', 'Dashboard Administración')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>@moneyformat(150000)</h3>
                <p>Cartera #1</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-folder"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>@moneyformat(150000)</h3>
                <p>Cartera #2</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-folder"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>@moneyformat(150000)</h3>
                <p>Cartera #3</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-folder"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>@moneyformat(150000)</h3>
                <p>Cartera #4</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-folder"></i></a>
        </div>
    </div>
</div>
    <div class="row">
        <!-- Online Store Visitors -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Online Store Visitors</div>
                <div class="card-body">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Sales -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Sales</div>
                <div class="card-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Products -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productsData as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['price'] }}</td>
                                    <td>{{ $product['sales'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
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
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de visitantes
        const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
        const visitorsChart = new Chart(visitorsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($visitorsData)) !!},
                datasets: [{
                    label: 'Visitors',
                    data: {!! json_encode(array_values($visitorsData)) !!},
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
                labels: {!! json_encode(array_keys($salesData)) !!},
                datasets: [{
                    label: 'Sales',
                    data: {!! json_encode(array_values($salesData)) !!},
                    backgroundColor: 'blue'
                }]
            }
        });
    </script>
@stop