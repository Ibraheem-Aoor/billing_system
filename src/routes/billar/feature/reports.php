<?php

use App\Http\Controllers\Billar\Reports\ClientStatementReportController;
use App\Http\Controllers\Billar\Reports\InvoiceReportController;
use App\Http\Controllers\Billar\Reports\PaymentSummaryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reports', 'middleware' => ['admin', 'individual_behavior']], function () {
    Route::get('payment-summary', [PaymentSummaryController::class, 'index'])
        ->name('reports.payment_summary');
    Route::get('invoice-report', [InvoiceReportController::class, 'index'])
        ->name('reports.invoice_report');
    Route::get('client-statement-report', [ClientStatementReportController::class, 'index'])
        ->name('reports.client_statement_report');
});