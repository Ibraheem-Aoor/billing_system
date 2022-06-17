<?php

use App\Http\Controllers\Billar\Country\CountryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'authorize']], function () {
    Route::get('countries', [CountryController::class, 'index'])->name('countries');
});