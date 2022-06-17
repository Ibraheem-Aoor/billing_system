<?php


namespace App\Services\Billar\Reports;


use App\Models\Billar\PaymentHistory\PaymentHistory;
use App\Services\Billar\ApplicationBaseService;

class PaymentSummaryReportService extends ApplicationBaseService
{
    public function __construct(PaymentHistory $paymentHistory)
    {
        $this->model = $paymentHistory;
    }
}