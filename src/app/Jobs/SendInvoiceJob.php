<?php

namespace App\Jobs;

use App\Mail\SendInvoiceMail;
use App\Models\Billar\Invoice\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected Invoice $invoice;
    protected string $subject;
    protected string $message;

    public function __construct(Invoice $invoice, $subject, $message)
    {
        $this->invoice = $invoice;
        $this->subject = $subject;
        $this->message = $message;
    }


    public function handle()
    {
        Mail::to(optional($this->invoice->client)->email)
            ->send(
                (new SendInvoiceMail($this->invoice, $this->subject, $this->message))
                    ->onQueue('high'));

        Storage::delete('public/pdf/send_invoice_' . $this->invoice->id . '.pdf');

    }
}
