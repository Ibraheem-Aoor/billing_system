<?php

namespace App\Http\Controllers\Billar\Invoice;

use App\Filters\Billar\Invoice\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Jobs\InvoiceAttachmentJob;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\Invoice\InvoiceDetail;
use App\Services\Billar\Invoice\InvoiceService;
use PDF;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(InvoiceService $service, InvoiceFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }


    public function index()
    {
        return $this->service
            ->with('status', 'client:id,first_name,last_name')
            ->filters($this->filter)
            ->orderBy('id', request()->get('orderBy'))
            ->paginate(request('per_page', 10));
    }


    public function store(Request $request)
    {
        $invoice = $this->service
            ->setValidation()
            ->setAttributes($request->all())
            ->save();

        $this->service->when($request->has('products'), fn(InvoiceService $service) => $service->invoiceDetails());

        $invoiceInfo = $this->service->loadInvoiceInfo($invoice);
        
        $this->service
            ->setAttribute('file_path', 'public/pdf/invoice_' . $invoice->id . '.pdf')
            ->pdfGenerate($invoiceInfo);

        InvoiceAttachmentJob::dispatch($invoiceInfo)->onQueue('high');
        return created_responses('invoices');
    }


    public function show($id)
    {
        return $this->service
            ->with([
                'client.profile', 'createdBy.profile',
                'invoiceDetails' => function ($query) {
                    $query->with('tax:id,name,value', 'product:id,name');
                }
            ])->find($id);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->service
            ->setModel($invoice)
            ->setValidation()
            ->setAttributes($request->only(
                'client_id',
                'invoice_number',
                'recurring',
                'date',
                'due_date',
                'status_id',
                'recurring_cycle_id',
                'sub_total',
                'discount_type',
                'discount',
                'total',
                'received_amount',
                'due_amount',
                'notes',
                'terms'
            ))
            ->update();
        $this->service->when($request->has('products'), fn(InvoiceService $service) => $service->invoiceDetails());
        return updated_responses('invoices');
    }


    public function destroy(Invoice $invoice)
    {
        $this->service
            ->setModel($invoice)
            ->delete();
        return deleted_responses('invoices');
    }

    public function detailsDelete()
    {
        $invoices = $this->service->find(request('id'));
        $invoices->update(request()->all());
        $invoice = InvoiceDetail::where('id', request('invoice_detail_id'))->delete();
        return deleted_responses('products', ['invoice' => $invoice]);
    }
}
