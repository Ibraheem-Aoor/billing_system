<?php


use App\Http\Controllers\Billar\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'authorize']], function () {

    Route::get('clients/list/view', [FrontendController::class, 'clientView'])
        ->middleware('can:view_clients');
    Route::get('clients/{id}/details', [FrontendController::class, 'clientDetailsView'])
        ->middleware('can:client_invoice_details');

    Route::get('invoices/list/view', [FrontendController::class, 'invoiceView'])
        ->middleware('can:view_invoices');
    Route::get('invoices/{id}/details', [FrontendController::class, 'invoiceDetails'])
        ->middleware('can:view_invoices');

    Route::get('payment/list/view', [FrontendController::class, 'paymentView'])
        ->middleware('can:view_payment_histories');

    Route::get('products/list/view', [FrontendController::class, 'productView'])
        ->middleware('can:view_products');

    Route::get('categories/list/view', [FrontendController::class, 'categoryView'])
        ->middleware('can:view_categories');

//    Route::get('general-summary', [FrontendController::class, 'generalSummaryView']);
    Route::get('payment-summary', [FrontendController::class, 'paymentSummaryView'])
        ->middleware('can:payment_summary_reports');
    Route::get('client-statement', [FrontendController::class, 'clientStatementView'])
        ->middleware('can:client_statement_report_reports');
    Route::get('invoice-report', [FrontendController::class, 'invoiceReportView'])
        ->middleware('can:invoice_report_reports');
    //Route::get('expense-report', [FrontendController::class, 'expenseReportView']);

    Route::get('app-setting', [FrontendController::class, 'settings'])
        ->name('app.settings')
        ->middleware('can:view_settings');

    Route::get('expenses/list/view', [FrontendController::class, 'expenseView'])
        ->middleware('can:view_expenses');

    Route::get('purposes/list/view', [FrontendController::class, 'purposeView'])
        ->middleware('can:view_purposes');
});