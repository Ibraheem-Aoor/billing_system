<?php

use App\Http\Controllers\Billar\Expense\PurposeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin'], function () {
    Route::apiResource('purposes', PurposeController::class);
});