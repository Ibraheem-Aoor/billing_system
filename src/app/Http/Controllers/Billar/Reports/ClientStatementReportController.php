<?php

namespace App\Http\Controllers\Billar\Reports;

use App\Filters\Billar\Reports\ClientStatementReportFilter;
use App\Http\Controllers\Controller;
use App\Services\Billar\Reports\ClientStatementReportService;
use Illuminate\Http\Request;

class ClientStatementReportController extends Controller
{
    public function __construct(ClientStatementReportService $service, ClientStatementReportFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }

    public function index()
    {
        return $this->service
            ->with('client:id,first_name,last_name', 'status:id,name,class')
            ->filters($this->filter)
            ->paginate(request('per_page', 10));
    }
}
