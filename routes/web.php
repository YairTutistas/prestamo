<?php

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\PortafoliosController;
use App\Http\Controllers\PaymentWompiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/payment', [PaymentWompiController::class, 'showPaymentForm'])->name('payment.form');


Route::get('/', function () {
    return redirect()->to('dashboard');
})->middleware(['auth', 'verified'])->name('welcome');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ChartController::class, 'index'])->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clients
    Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
    Route::prefix('admin')->group(function () {
        Route::get('/clients', [ClientsController::class, 'indexAdmin'])->name('admin');
    });
    Route::prefix('cobrador')->group(function () {
        Route::get('/clients', [ClientsController::class, 'indexCobrador'])->name('cobrador');
    });
    Route::get('/createClient', [ClientsController::class, 'create'])->name('createClient');
    Route::post('/saveClient', [ClientsController::class, 'save'])->name('saveClient');
    Route::get('deleteClient/{id}', [ClientsController::class, 'delete'])->name('deleteClient');
    Route::get('/showClient/{id}', [ClientsController::class, 'show'])->name('showClient');
    Route::post('/updateClient/{id}', [ClientsController::class, 'update'])->name('updateClient');
    Route::get('/loansClient/{client}', [ClientsController::class, 'loans'])->name('loansClient');
    Route::get('/showLoanClient/{client}', [ClientsController::class, 'LoanClient'])->name('showLoanClient');


    // Portafolio
    Route::get('/portafolios', [PortafoliosController::class, 'index'])->name('portafolios');
    Route::get('/createPortafolio', [PortafoliosController::class, 'create'])->name('createPortafolio');
    Route::post('/savePortafolio', [PortafoliosController::class, 'save'])->name('savePortafolio');
    Route::delete('/deletePortafolio/{id}', [PortafoliosController::class, 'delete'])->name('deletePortafolio');
    Route::get('/showPortafolio/{id}', [PortafoliosController::class, 'show'])->name('showPortafolio');
    Route::post('/updatePortafolio/{id}', [PortafoliosController::class, 'update'])->name('updatePortafolio');


    // Loans - Prestamos
    Route::get('/loans', [LoansController::class, 'index'])->name('loans');
    Route::get('/createLoan', [LoansController::class, 'create'])->name('createLoan');
    Route::post('/saveLoan', [LoansController::class, 'save'])->name('saveLoan');
    Route::delete('/deleteLoan/{id}', [LoansController::class, 'delete'])->name('deleteLoan');
    Route::get('/showLoan/{id}', [LoansController::class, 'show'])->name('showLoan');
    Route::post('/updateLoan/{id}', [LoansController::class, 'update'])->name('updateLoan');
    Route::get('/approveLoan/{id}', [LoansController::class, 'Approve'])->name('approveLoan');
    Route::get('/pendingLoan', [LoansController::class, 'loanPending'])->name('pendingLoan');
    Route::get('/confirm/{id}', [LoansController::class, 'confirm'])->name('confirm');
    Route::get('/cancelConfirm/{id}', [LoansController::class, 'cancelConfirm'])->name('cancel');
    Route::get('/pendientCounter', [LoansController::class, 'loanPendientCounter'])->name('pendientCounter');


    // Payments
    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments');
    Route::get('/createPayment', [PaymentsController::class, 'create'])->name('createPayment');
    Route::post('/savePayment', [PaymentsController::class, 'save'])->name('savePayment');
    Route::get('/showPayment/{id}', [PaymentsController::class, 'show'])->name('showPayment');
    Route::get('/generateInvoice/{id}', [PaymentsController::class, 'generateInvoice'])->name('generateInvoice');

    // Companies
    Route::get('/company', [CompaniesController::class, 'index'])->name('company');
    Route::get('/createCompany', [CompaniesController::class, 'create'])->name('createCompany');
    Route::post('/saveCompany', [CompaniesController::class, 'store'])->name('saveCompany');



    Route::group(['middleware' => ['role:Admin']], function () { 
        Route::delete('/deletePayment/{id}', [PaymentsController::class, 'delete'])->name('deletePayment');

    });
});

require __DIR__.'/auth.php';
