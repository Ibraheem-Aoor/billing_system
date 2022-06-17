<?php

namespace App\Mail\Tag;

class InvoiceTag extends Tag
{
    protected object $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function invoiceGenerate(): array
    {
        return $this->notification();
    }

    public function notification(): array
    {
        return array_merge([
            '{receiver_name}' => $this->invoice->client->full_name,
            '{invoice_number}' => $this->invoice->invoice_number,
            '{date}' => $this->invoice->due_date,
        ], $this->appNameAndLogo());
    }
}