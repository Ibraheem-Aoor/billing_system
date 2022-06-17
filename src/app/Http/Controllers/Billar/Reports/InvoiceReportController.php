<?php

namespace App\Http\Controllers\Billar\Reports;

use App\Filters\Billar\Reports\InvoiceReportFilter;
use App\Http\Controllers\Controller;
use App\Services\Billar\Reports\InvoiceReportService;


class InvoiceReportController extends Controller
{
    public function __construct(InvoiceReportService $service, InvoiceReportFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }
    public function index()
    {
        return $this->service
            ->with('status', 'client')
            ->filters($this->filter)
            ->paginate(request('per_page', 10));
    }
}
