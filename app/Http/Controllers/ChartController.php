<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        // Datos de visitantes
        $visitorsData = [
            '18th' => 100,
            '20th' => 120,
            '22nd' => 140,
            '24th' => 160,
            '26th' => 180,
            '28th' => 160,
            '30th' => 150,
        ];

        // Datos de ventas
        $salesData = [
            'JUN' => 1000,
            'JUL' => 2000,
            'AUG' => 3000,
            'SEP' => 2500,
            'OCT' => 3000,
            'NOV' => 2000,
            'DEC' => 3000,
        ];

        // Datos de productos
        $productsData = [
            [
                'name' => 'Some Product',
                'price' => '$13 USD',
                'sales' => '12,000 Sold',
                'change' => '12%',
                'changeType' => 'up'
            ],
            [
                'name' => 'Another Product',
                'price' => '$29 USD',
                'sales' => '123,234 Sold',
                'change' => '0.5%',
                'changeType' => 'down'
            ],
            [
                'name' => 'Amazing Product',
                'price' => '$1,230 USD',
                'sales' => '198 Sold',
                'change' => '3%',
                'changeType' => 'down'
            ],
            [
                'name' => 'Perfect Item',
                'price' => '$199 USD',
                'sales' => '87 Sold',
                'change' => '63%',
                'changeType' => 'up'
            ]
        ];

        // Resumen de la tienda
        $storeOverview = [
            'conversion_rate' => '12%',
            'sales_rate' => '0.8%',
            'registration_rate' => '-1%'
        ];

        return view('dashboard', compact('visitorsData', 'salesData', 'productsData', 'storeOverview'));
    }
}
