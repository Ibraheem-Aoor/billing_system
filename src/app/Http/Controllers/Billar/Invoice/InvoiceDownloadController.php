<?php

namespace App\Http\Controllers\Billar\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Billar\Invoice\Invoice;
use PDF;
use SPDF;
use TPDF;

class InvoiceDownloadController extends Controller
{
    public function download(Invoice $invoice)
    {
        $invoiceInfo = $invoice->load(['invoiceDetails' => function ($query) {
            $query->with('product:id,name', 'tax:id,name,value');
        }, 'client.profile', 'createdBy.profile']);
        $invoiceInfo->totalTax = $invoiceInfo->invoiceDetails->map(function ($item) {
            $tax = $item->load('tax')->tax ? $item->load('tax')->tax->value : 0;
            return $this->productTaxSum($item->quantity, $item->price, $tax);
        })->sum();

        $pdf = TPDF::loadView('invoices.invoice-generate', [
            'invoice' => $invoiceInfo
        ]);
        $downloadablePDf = TPDF::HTML($pdf);
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont  = true;

        return $pdf->download('invoice' . $invoice->invoice_number . '.pdf');
    }

    protected function productTaxSum($quantity, $price, $taxValue)
    {
        return (($quantity * $price) * ($taxValue / 100));
    }


}
