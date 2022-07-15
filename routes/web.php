<?php

use App\Http\Controllers\Ajax\CustomerAjaxController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/customers');
Route::resource('/customers', CustomerController::class);
Route::resource('/bills', BillController::class);
Route::post('bills/notificar-geiko', [BillController::class, 'notifygeiko'])->name('bills.notifygeiko');

Route::view('/config/index', 'config/index')->name('config.index');

Route::post('/config', [ConfigController::class, 'run'])->name('config.run');


#ajax routes
Route::get('/consultaClienteBycnpj', [CustomerAjaxController::class, 'consultaClienteByCNPJ']);
