<?php

use App\Helpers\App\General\NumberFormatterHelper;

if (!function_exists('number_with_currency_symbol')) {
    function number_with_currency_symbol($number)
    {
        return resolve(NumberFormatterHelper::class)->numberWithCurrencySymbol($number);
    }
}