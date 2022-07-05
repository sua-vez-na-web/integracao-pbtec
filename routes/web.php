<?php

use App\Http\Controllers\Ajax\CustomerAjaxController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/customers');
Route::resource('/customers', CustomerController::class);
Route::resource('/bills', BillController::class);
Route::post('bills/notificar-geiko', [BillController::class, 'notifygeiko'])->name('bills.notifygeiko');

#ajax routes
Route::get('/consultaClienteBycnpj', [CustomerAjaxController::class, 'consultaClienteByCNPJ']);
