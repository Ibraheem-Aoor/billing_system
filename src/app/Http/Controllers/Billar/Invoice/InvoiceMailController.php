<?php

namespace App\Http\Controllers\Billar\Invoice;

use App\Http\Controllers\Controller;
use App\Jobs\InvoiceAttachmentJob;
use App\Jobs\SendInvoiceJob;
use App\Models\Billar\Invoice\Invoice;
use App\Services\Billar\Invoice\InvoiceService;
use Illuminate\Http\Request;

class InvoiceMailController extends Controller
{
    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function sendInvoice(Request $request, Invoice $invoice)
    {
        $this->service
            ->setSendInvoiceValidation();

        $invoiceInfo = $this->service->loadInvoiceInfo($invoice);

        $this->service
            ->setAttribute('file_path', 'public/pdf/send_invoice_' . $invoice->id . '.pdf')
            ->pdfGenerate($invoiceInfo);


        $message = $this->service->tags($invoiceInfo, $request->message);

        SendInvoiceJob::dispatch($invoiceInfo, $request->subject, $message)->onQueue('high');

        return response()->json([
            'status' => true,
            'message' => trans('default.invoice_email_send'),
        ]);
    }

    public function resendInvoice(Invoice $invoice): \Illuminate\Http\JsonResponse
    {
        $invoiceInfo = $this->service->loadInvoiceInfo($invoice);

        $this->service
            ->setAttribute('file_path', 'public/pdf/invoice_' . $invoice->id . '.pdf')
            ->pdfGenerate($invoiceInfo);

        InvoiceAttachmentJob::dispatch($invoiceInfo)->onQueue('high');

        return response()->json([
            'status' => true,
            'message' => trans('default.invoice_send_success'),
        ], 200);
    }

}
