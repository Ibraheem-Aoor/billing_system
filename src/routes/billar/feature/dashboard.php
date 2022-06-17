<?php

use App\Http\Controllers\Billar\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['admin', 'individual_behavior']], function () {
    Route::get('dashboard-card', [DashboardController::class, 'card'])->name('card.dashboard');
    Route::get('payment-overview', [DashboardController::class, 'paymentOverview'])->name('overview.payment');
    Route::get('yearly-overview', [DashboardController::class, 'YearlyOverview'])->name('overview.yearly');
});