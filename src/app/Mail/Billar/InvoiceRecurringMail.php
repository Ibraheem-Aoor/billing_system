<?php
  
  namespace App\Mail\Billar;
  
  use App\Mail\Tag\InvoiceTag;
  use App\Notifications\Core\Helper\NotificationTemplateHelper;
  use Illuminate\Bus\Queueable;
  use Illuminate\Mail\Mailable;
  use Illuminate\Queue\SerializesModels;
  use PDF;
  
  class InvoiceRecurringMail extends Mailable
  {
	use Queueable, SerializesModels;
	
	protected $invoice;
	
	protected string $template;
	
	protected $pdf;
	
	public function __construct($invoice, $pdf)
	{
	  $tag = new InvoiceTag($invoice);
	  
	  $this->invoice = $invoice;
	  
	  $template = $this->template();
	  
	  $this->pdf = $pdf;
	  
	  $this->template = optional($template)->parse(
		  method_exists($tag, 'invoiceGenerate') ? $tag->invoiceGenerate() : ['{invoice_number}' => optional($this->invoice)->invoice_number]
	  );
	  
	  $this->subject = optional($template)->parseSubject(
		  method_exists($tag, 'invoiceGenerate') ? $tag->invoiceGenerate() : ['{invoice_number}' => optional($this->invoice)->invoice_number]
	  );
	  
	}
	
	/**
	 * @return InvoiceRecurringMail
	 */
	public function build()
	{
	  return $this->view('notification.mail.user.template', [
		  'template' => $this->template
	  ])->subject($this->subject)
		  ->attach(storage_path('app/public/pdf/invoice_recurring_' . $this->invoice->id . '.pdf'), [
			  'as' => 'invoice_recurring.pdf',
			  'mime' => 'application/pdf',
		  ]);
	}
	
	public function template(): \App\Models\Core\Notification\NotificationTemplate
	{
	  return NotificationTemplateHelper::new()
		  ->on('invoice_payment_reminder')
		  ->mail();
	}
  }
