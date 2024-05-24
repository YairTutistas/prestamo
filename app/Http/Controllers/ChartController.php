<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        $payments = Payments::selectRaw('payment_date as day, SUM(amount) as total')
                            ->groupBy('day')
                            ->pluck('total', 'day')->toArray();

        // Formatear los datos para Chart.js
        $labels = array_keys($payments);
        $data = array_values($payments);

        return view('/dashboard', compact('labels', 'data'));
    }
}
