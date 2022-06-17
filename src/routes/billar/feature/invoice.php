<?php

use App\Http\Controllers\Billar\Invoice\InvoiceController;
use App\Http\Controllers\Billar\Invoice\InvoiceDownloadController;
use App\Http\Controllers\Billar\Invoice\InvoiceMailController;
use App\Http\Controllers\Billar\PaymentHistory\InvoicePaymentController;
use App\Http\Controllers\Billar\PaymentHistory\PaymentHistoryController;
use App\Http\Controllers\Billar\PaymentHistory\PaypalController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['admin', 'individual_behavior']], function () {
    Route::apiResource('invoices', InvoiceController::class);
    Route::post('invoice-details-delete', [InvoiceController::class, 'detailsDelete'])
        ->name('product.delete_invoice_details');
    Route::apiResource('payment-histories', PaymentHistoryController::class);
    Route::post('invoice-send/{invoice}', [InvoiceMailController::class, 'sendInvoice'])
        ->name('send.invoice');
    Route::get('invoice-download/{invoice}', [InvoiceDownloadController::class, 'download'])
        ->name('download.invoice');
    Route::get('invoice-resend/{invoice}', [InvoiceMailController::class, 'resendInvoice'])
        ->name('resend.invoice');
    Route::post('checkout', [InvoicePaymentController::class, 'checkout'])
        ->name('checkout.invoice');
});


