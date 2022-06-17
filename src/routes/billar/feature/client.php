<?php

use App\Http\Controllers\Billar\Client\ClientController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin'], function () {
    Route::apiResource('clients', ClientController::class);
    Route::get('clients-invoice/{id}', [ClientController::class, 'clientInvoices'])->name('invoice_details.client');

});