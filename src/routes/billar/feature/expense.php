<?php

use App\Http\Controllers\Billar\Expense\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin'], function () {

    Route::apiResource('expenses', ExpenseController::class);
});

Route::group(['middleware' => ['auth', 'authorize']], function () {
    Route::get('expenses/summery', [ExpenseController::class,'getSummery'])
        ->name('expense.summery');
});