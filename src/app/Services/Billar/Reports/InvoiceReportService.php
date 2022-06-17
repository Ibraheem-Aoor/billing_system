<?php


namespace App\Services\Billar\Reports;


use App\Models\Billar\Invoice\Invoice;
use App\Services\Billar\ApplicationBaseService;

class InvoiceReportService extends ApplicationBaseService
{
    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }
}