<?php

namespace App\Jobs;

use App\Mail\Billar\InvoiceRecurringMail;
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

class InvoiceRecurringJob implements ShouldQueue
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
		  ->send(new InvoiceRecurringMail($this->invoice, $invoiceInfo));
    }
    
    public function invoiceInfo()
	{
	  $invoiceInfo = $this->invoice->load(['invoiceDetails' => function ($query) {
		$query->with('product:id,name', 'tax:id,name,value');
	  }, 'client:id,first_name,last_name,email', 'createdBy:id,first_name,last_name']);
	  
	  $pdf = PDF::loadView('invoices.invoice-generate', [
		  'invoice' => $invoiceInfo
	  ]);
	  
	  $output = $pdf->output();
	  Storage::put('public/pdf/invoice_recurring_' . $this->invoice->id . '.pdf', $output);
	  return $this;
	}
}
