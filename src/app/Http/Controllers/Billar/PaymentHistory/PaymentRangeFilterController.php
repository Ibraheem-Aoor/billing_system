<?php

namespace App\Http\Controllers\Billar\PaymentHistory;

use App\Filters\Billar\PaymentHistory\PaymentHistoryFilter;
use App\Http\Controllers\Controller;
use App\Services\Billar\PaymentHistory\PaymentHistoryService;

class PaymentRangeFilterController extends Controller
{
    public function __construct(PaymentHistoryService $service, PaymentHistoryFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }

    public function rangeFilter(): array
    {
        $payment['max_amount'] = $this->service->max('amount') ?? 0;
        $payment['min_amount'] = $this->service->min('amount') ?? 0;
        return $payment;
    }
}
