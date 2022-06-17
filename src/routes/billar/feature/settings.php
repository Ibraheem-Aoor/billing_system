<?php
//Payment method

use App\Http\Controllers\App\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\Billar\Setting\InvoiceSettingController;
use App\Http\Controllers\Billar\Tax\TaxController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin'], function () {

    Route::get('payment-method-status', [PaymentMethodController::class, 'paymentMethodStatus'])
        ->name('payment_method.status');
    Route::apiResource('payment-method', PaymentMethodController::class);

    Route::post('invoice/settings', [InvoiceSettingController::class, 'setting'])
        ->name('invoice-setting');

    Route::apiResource('taxes', TaxController::class);

});