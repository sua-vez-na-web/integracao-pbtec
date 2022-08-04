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

Route::get('/updateBill/{fatura}', [BillController::class, 'updateBill'])->name('bills.update');
Route::get('/getBill/{fatura}', [BillController::class, 'getBill'])->name('bills.get');
Route::get('/notifyBill/{fatura}', [BillController::class, 'notifyBill'])->name('bills.notify');


#ajax routes
Route::get('/consultaClienteBycnpj', [CustomerAjaxController::class, 'consultaClienteByCNPJ']);
