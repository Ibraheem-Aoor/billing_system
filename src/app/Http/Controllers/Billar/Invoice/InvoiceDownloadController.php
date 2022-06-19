<?php

namespace App\Http\Controllers\Billar\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Billar\Invoice\Invoice;
use PDF;
use SPDF;
use TPDF;
use Gainhq\Installer\App\Managers\DownloadManager;

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

        $pdf = view('invoices.invoice-generate', [
            'invoice' => $invoiceInfo
        ])->render();
        $pdfarr = [
          // 'title'=>'اهلا بكم ',
          'data'=>$pdf, // render file blade with content html
          'header'=>['show'=>false], // header content
          'footer'=>['show'=>false], // Footer content
          'font'=>'aealarabiya', //  dejavusans, aefurat ,aealarabiya ,times
          'font-size'=>12, // font-size 
          'text'=>'', //Write
          'rtl'=>true, //true or false 
          'creator'=>'phpanonymous', // creator file - you can remove this key
          'keywords'=>'phpanonymous keywords', // keywords file - you can remove this key
          'subject'=>'phpanonymous subject', // subject file - you can remove this key
          'filename'=>'phpanonymous.pdf', // filename example - invoice.pdf
          'display'=>'download', // stream , download , print
        ];
        // $pdf->autoScriptToLang = true;
        // $pdf->autoLangToFont  = true;
          return \TPDF::HTML($pdfarr);
        // return $downloadalbePdf->download('invoice' . $invoice->invoice_number . '.pdf');
    }

    protected function productTaxSum($quantity, $price, $taxValue)
    {
        return (($quantity * $price) * ($taxValue / 100));
    }


}
