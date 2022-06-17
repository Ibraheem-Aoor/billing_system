<?php
  
  namespace App\Models\Billar\Invoice;
  
  use Illuminate\Database\Eloquent\Model;
  
  class InvoiceRecurring extends Model
  {
	public $timestamps = false;
	
	protected $fillable = [
		'id', 'invoice_id', 'referance_invoice_id', 'recurring_date'
	];
	
  }
