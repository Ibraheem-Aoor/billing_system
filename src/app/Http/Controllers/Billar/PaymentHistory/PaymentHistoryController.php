<?php

namespace App\Http\Controllers\Billar\PaymentHistory;

use App\Filters\Billar\PaymentHistory\PaymentHistoryFilter;
use App\Http\Controllers\Controller;
use App\Jobs\InvoiceAttachmentJob;
use App\Models\Billar\PaymentHistory\PaymentHistory;
use App\Services\Billar\PaymentHistory\PaymentHistoryService;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function __construct(PaymentHistoryService $service, PaymentHistoryFilter $filter)
    {
        $this->service = $service;
        $this->filter = $filter;
    }

    public function index()
    {
        return $this->service
            ->whereHas('invoice', function ($query) {
                $query->when(!auth()->user()->can('show_all_data'), function ($query) {
                    $query->where('client_id', auth()->id());
                });
            })->with(['paymentMethod:id,name', 'invoice' => function ($query) {
                    $query->select('id', 'invoice_number', 'client_id')
                        ->with('client:id,first_name,last_name');
                }]
            )->filters($this->filter)
            ->orderBy('id', request()->get('orderBy'))
            ->paginate(request('per_page'));
    }


    public function store(Request $request)
    {
        $payment = $this->service
            ->setValidation()
            ->dueAmountUpdate()
            ->setAttributes($request->all())
            ->save();

        $invoiceInfo = $payment->load('invoice')->invoice;
        $this->service
            ->setAttribute('file_path', 'public/pdf/invoice_' . $invoiceInfo->id . '.pdf')
            ->pdfGenerate($invoiceInfo);

        InvoiceAttachmentJob::dispatch($invoiceInfo)->onQueue('high');
        return created_responses('payments');
    }


    public function show($id)
    {
        return $this->service->find($id);
    }


    public function update(Request $request, PaymentHistory $payment_history)
    {
        $this->service
            ->setModel($payment_history)
            ->setValidation()
            ->adjustDueAmount()
            ->setAttributes($request->all())
            ->update();
        return updated_responses('payments');
    }


    public function destroy(PaymentHistory $payment_history)
    {
        $this->service
            ->setModel($payment_history)
            ->delete();
        return deleted_responses('payments');
    }
}
