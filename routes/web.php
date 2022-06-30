<?php

use App\Http\Controllers\Ajax\CustomerAjaxController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/customers');

Route::resource('/customers', CustomerController::class);


Route::get('/consultaClienteBycnpj', [CustomerAjaxController::class, 'consultaClienteByCNPJ']);
