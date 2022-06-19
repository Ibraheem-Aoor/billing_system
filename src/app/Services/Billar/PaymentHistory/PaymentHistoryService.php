<?php


namespace App\Services\Billar\PaymentHistory;


use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\PaymentHistory\PaymentHistory;
use App\Models\Core\Status;
use App\Services\Billar\ApplicationBaseService;
use Illuminate\Support\Facades\Storage;
use SPDF;

class PaymentHistoryService extends ApplicationBaseService
{

    public function __construct(PaymentHistory $paymentHistory)
    {
        $this->model = $paymentHistory;
    }

    public function setValidation(): self
    {
        validator(request()->all(), [
            'invoice_id' => 'required',
            'payment_method_id' => 'required',
            'received_on' => 'required|date',
            'amount' => 'required',
            'note' => 'required'
        ], [
            'invoice_id.required' => 'The invoice field is required.',
            'payment_method_id.required' => 'The payment method field is required.',
        ])->validate();

        return $this;
    }

    public function dueAmountUpdate(): self
    {
        $invoice = Invoice::where('id', request('invoice_id'));
        $invoice->decrement('due_amount', request('amount'));
        $invoice->increment('received_amount', request('amount'));
        //Status adjustment
        $this->statusAdjustment($invoice);
        return $this;
    }

    public function adjustDueAmount(): self
    {
        $invoice = Invoice::where('id', request('invoice_id'));
        if (request('amount') != request('old_amount')) {
            if (request('amount') > request('old_amount')) {
                $invoice->decrement('due_amount', (request('amount') - request('old_amount')));
                $invoice->increment('received_amount', (request('amount') - request('old_amount')));
            } else {
                $invoice->increment('due_amount', (request('old_amount') - request('amount')));
                $invoice->decrement('received_amount', (request('old_amount') - request('amount')));
            }
        }
        //Status adjustment
        $this->statusAdjustment($invoice);
        return $this;
    }

    /**
     * @param $invoice
     */
    public function statusAdjustment($invoice): void
    {
        $invoiceData = $invoice->first();
        $paidStatusId = Status::findByNameAndType('status_paid', 'invoice')->id;
        $partiallyPaidStatusId = Status::findByNameAndType('status_partially_paid', 'invoice')->id;
        if ($invoiceData->received_amount == $invoiceData->total) {
            $invoice->update([
                'status_id' => $paidStatusId
            ]);
        } elseif ($invoiceData->received_amount < $invoiceData->total) {
            $invoice->update([
                'status_id' => $partiallyPaidStatusId
            ]);
        }
    }

    public function pdfGenerate($invoiceInfo):self
    {
      return dd('payment_history');

        $pdf = \SPDF::loadView('invoices.invoice-generate', [
            'invoice' => $invoiceInfo
        ]);

        $output = $pdf->output();
        $filePath = $this->getAttribute('file_path');
        Storage::put($filePath, $output);
        return $this;
    }

}