<?php

use App\Http\Controllers\App\Settings\SettingsApiController;
use App\Http\Controllers\Billar\Expense\PurposeController;
use App\Http\Controllers\Billar\Invoice\InvoiceRangeFilterController;
use App\Http\Controllers\Billar\PaymentHistory\PaymentRangeFilterController;
use App\Http\Controllers\Billar\Setting\CronJobSettingController;
use App\Http\Controllers\Billar\Setting\EmailDeliveryCheckController;
use App\Http\Controllers\Billar\Support\SupportApiController;
use App\Http\Controllers\Billar\User\BillarUserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'authorize']], function () {
    //Route::delete('delete-address/{clientAddress}', [SupportApiController::class, 'deleteAddress']);
    Route::get('recurring-cycle', [SupportApiController::class, 'recurringCycle']);
    Route::get('all-invoice', [SupportApiController::class, 'invoice']);
    Route::get('all-payment-method', [SupportApiController::class, 'paymentMethod']);
    Route::get('client-users', [SupportApiController::class, 'clientUser']);
    Route::get('all-currency', [SupportApiController::class, 'currency']);
    Route::get('all-category', [SupportApiController::class, 'category']);
    Route::get('invoice-number', [SupportApiController::class, 'invoiceNumber']);
    Route::get('all-taxes', [SupportApiController::class, 'taxes']);
    Route::get('system-roles', [SupportApiController::class, 'roles']);
    Route::get('check-mail-delivery-setting', [EmailDeliveryCheckController::class, 'isExists'])
        ->name('check_mail_delivery_setting');
    Route::get('invoice-range-filter', [InvoiceRangeFilterController::class, 'rangeFilter']);
    Route::get('payment-range-filter', [PaymentRangeFilterController::class, 'rangeFilter']);
    Route::get('invoice-summation', [SupportApiController::class, 'invoiceSummation']);
    Route::get('payment-summation', [SupportApiController::class, 'paymentSummation']);
    Route::get('expense-summation', [SupportApiController::class, 'getSummery']);
    Route::delete('billar/user-delete/{user}', [BillarUserController::class, 'userDelete']);
    Route::get('settings/cronjob', [CronJobSettingController::class, 'index']);
    Route::get('purpose-list', [PurposeController::class, 'getPurposeList']);
    Route::get('general-settings', [SettingsApiController::class, 'index']);
});

