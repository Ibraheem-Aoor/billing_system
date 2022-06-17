<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected string $message;
    protected object $invoice;

    /**
     * Create a new message instance.
     *
     * @param $invoice
     * @param $subject
     * @param $message
     */
    public function __construct($invoice, $subject, $message)
    {
        $this->invoice = $invoice;
        $this->subject = $subject;
        $this->message = $message;
    }


    public function build(): SendInvoiceMail
    {

        return $this->subject($this->subject)
            ->view('invoices.send-invoice-mail', ['template' => $this->message])
            ->attach(storage_path('app/public/pdf/send_invoice_' . $this->invoice->id . '.pdf'), [
                'as' => 'invoice.pdf',
                'mime' => 'application/pdf',
            ]);

    }
}
