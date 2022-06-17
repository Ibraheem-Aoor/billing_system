<?php

namespace App\Http\Controllers\Billar\Invoice;

use App\Filters\Billar\Invoice\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Services\Billar\Invoice\InvoiceService;

class InvoiceRangeFilterController extends Controller
{
    public function __construct(InvoiceService $service, InvoiceFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }

    public function rangeFilter(): array
    {
        $invoice['max_invoice_amount'] = $this->service->max('sub_total') ?? 0;
        $invoice['min_invoice_amount'] = $this->service->min('sub_total') ?? 0;
        $invoice['max_invoice_paid'] = $this->service->max('received_amount') ?? 0;
        $invoice['min_invoice_paid'] = $this->service->min('received_amount') ?? 0;
        $invoice['max_invoice_due'] = $this->service->max('due_amount') ?? 0;
        $invoice['min_invoice_due'] = $this->service->min('due_amount') ?? 0;
        return $invoice;
    }
}
