<?php

use App\Http\Controllers\Billar\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'authorize']], function () {
    Route::apiResource('products', ProductController::class);
});