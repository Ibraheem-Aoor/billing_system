<?php

namespace App\Jobs;

use App\Mail\Billar\PaymentReminderMail;
use App\Models\Billar\Invoice\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class PaymentReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected Invoice $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }


    public function handle()
    {
        $invoiceInfo = $this->invoiceInfo();
        Mail::to(optional($this->invoice->client)->email)
            ->send(new PaymentReminderMail($this->invoice, $invoiceInfo));

        Storage::delete('public/pdf/payment_reminder_' . $this->invoice->id . '.pdf');
    }

    protected function invoiceInfo(): self
    {
        $invoiceInfo = $this->invoice->load(['invoiceDetails' => function ($query) {
            $query->with('product:id,name', 'tax:id,name,value');
        }, 'client:id,first_name,last_name,email', 'createdBy:id,first_name,last_name']);

        $invoiceInfo->totalTax = $invoiceInfo->invoiceDetails->map(function ($item) {
            $tax = $item->load('tax')->tax ? $item->load('tax')->tax->value : 0;
            return $this->productTaxSum($item->quantity, $item->price, $tax);
        })->sum();

        $pdf = PDF::loadView('invoices.invoice-generate', [
            'invoice' => $invoiceInfo
        ]);

        $output = $pdf->output();
        Storage::put('public/pdf/payment_reminder_' . $this->invoice->id . '.pdf', $output);
        return $this;
    }


    protected function productTaxSum($quantity, $price, $taxValue)
    {
        return (($quantity * $price) * ($taxValue / 100));
    }
}
