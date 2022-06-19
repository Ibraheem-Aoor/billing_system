<?php

namespace App\Services\Billar\PaymentHistory;

use App\Jobs\InvoiceAttachmentJob;
use App\Models\App\PaymentMethods\PaymentMethod;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\PaymentHistory\PaymentHistory;
use App\Models\Core\Status;
use App\Services\Billar\ApplicationBaseService;
use Stripe\{Charge, Customer, Stripe};
use Illuminate\Support\Facades\Storage;
use SPDF;

class InvoicePaymentService extends ApplicationBaseService
{
    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }

    public function stripePayment(): self
    {
        Stripe::setApiKey(config()->get('services.stripe.secret_key'));
        $customer = Customer::create([
            'email' => request('stripeEmail'),
            'source' => request('stripeToken')
        ]);

        $charge = Charge::create([
            'customer' => $customer->id,
            'amount' => request('amount') * 100,
            'currency' => 'usd',
        ]);

        //succeeded
        if ($charge->status == 'succeeded') {
            $this->updateInvoice()
                ->paymentHistory();
        }
        return $this;

    }

    public function paypalPayment(): self
    {
        return $this->updateInvoice()
            ->paymentHistory();
    }

    public function updateInvoice(): self
    {
        $invoice = $this->model::query()
            ->where('id', request('invoice_id'));
        $invoice->decrement('due_amount', request('amount'));
        $invoice->increment('received_amount', request('amount'));
        $invoice->update(['status_id' => Status::findByNameAndType('status_paid', 'invoice')->id]);
        return $this;
    }

    public function paymentHistory(): self
    {
        $payment = PaymentHistory::create([
            'invoice_id' => request('invoice_id'),
            'payment_method_id' => PaymentMethod::where('alias', request('payment_type'))->first()->id,
            'received_on' => date('Y-m-d'),
            'amount' => request('amount')
        ]);

        $invoiceInfo = $payment->load('invoice')->invoice;

        $this->setAttribute('file_path', 'public/pdf/invoice_' . $invoiceInfo->id . '.pdf')
            ->pdfGenerate($invoiceInfo);

        InvoiceAttachmentJob::dispatch($invoiceInfo)->onQueue('high');

        return $this;
    }

    public function pdfGenerate($invoiceInfo): self
    {
        $pdf = \SPDF::loadView('invoices.invoice-generate', [
            'invoice' => $invoiceInfo
        ]);

        $output = $pdf->output();
        $filePath = $this->getAttribute('file_path');
        Storage::put($filePath, $output);
        return $this;
    }

}