<?php

namespace App\Http\Controllers\Billar\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function clientView()
    {
        return view('clients.index');
    }

    public function clientDetailsView($id)
    {
        return view('clients.client-details', compact('id'));
    }

    public function invoiceView()
    {
        return view('invoices.index');
    }

    public function invoiceDetails($id)
    {
        return view('invoices.invoice-details', compact('id'));
    }

    public function paymentView()
    {
        return view('payments.index');
    }

    public function productView()
    {
        return view('products.index');
    }

    public function categoryView()
    {
        return view('products.categories');
    }

//    public function generalSummaryView()
//    {
//        return view('reports.general-summary-report');
//    }

    public function paymentSummaryView()
    {
        return view('reports.payment-summary-report');
    }

    public function clientStatementView()
    {
        return view('reports.client-statement-report');
    }

    public function invoiceReportView()
    {
        return view('reports.invoice-report');
    }

    public function expenseReportView()
    {
        return view('reports.expense-report');
    }

    public function settings()
    {
        return view('settings.app-setting');
    }

    public function expenseView()
    {
        return view('expense.index');
    }

    public function purposeView()
    {
        return view('purpose.index');
    }


}
