<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PortafoliosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/roles', [RolesController::class, 'index']);
Route::post('/create', [RolesController::class, 'create']);


// Clients
Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
Route::post('/createClient', [ClientsController::class, 'create'])->name('createClient');
Route::delete('deleteClient/{id}', [ClientsController::class, 'delete'])->name('deleteClient');
Route::get('/showClient/{id}', [ClientsController::class, 'show'])->name('showClient');
Route::post('/updateClient/{id}', [ClientsController::class, 'update'])->name('updateClient');


// Portafolio
Route::get('/portafolios', [PortafoliosController::class, 'index'])->name('portafolios');
Route::post('/createPortafolio', [PortafoliosController::class, 'create'])->name('createPortafolio');
Route::delete('/deletePortafolio/{id}', [PortafoliosController::class, 'delete'])->name('deletePortafolio');
Route::get('/showPortafolio/{id}', [PortafoliosController::class, 'show'])->name('showPortafolio');
Route::post('/updatePortafolio/{id}', [PortafoliosController::class, 'update'])->name('updatePortafolio');


// Loans - Prestamos
Route::get('/loans', [LoansController::class, 'index'])->name('loans');
Route::post('/createLoan', [LoansController::class, 'create'])->name('createLoan');
Route::delete('/deleteLoan/{id}', [LoansController::class, 'delete'])->name('deleteLoan');
Route::get('/showLoan/{id}', [LoansController::class, 'show'])->name('showLoan');
Route::post('/updateLoan/{id}', [LoansController::class, 'update'])->name('updateLoan');


// Payments
Route::get('/payments', [PaymentsController::class, 'index'])->name('payments');
Route::get('/createPayment', [PaymentsController::class, 'create'])->name('createPayment');
Route::post('/savePayment', [PaymentsController::class, 'save'])->name('savePayment');
Route::get('/showPayment/{id}', [PaymentsController::class, 'show'])->name('showPayment');
Route::delete('/deletePayment/{id}', [PaymentsController::class, 'delete'])->name('deletePayment');


// Usuario
Route::post('/createUser', [RegisterController::class, 'create']);
