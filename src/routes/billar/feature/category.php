<?php

use App\Http\Controllers\Billar\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin'], function () {
    Route::apiResource('categories', CategoryController::class);
});