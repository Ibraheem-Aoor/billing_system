<?php
  
  namespace App\Models\Billar\Invoice;
  
  use App\Models\Billar\Recurring\RecurringCycle;
  use App\Models\Core\BaseModel;
  use App\Models\Core\Status;
  use App\Models\Core\Traits\BootTrait;
  use App\Models\Core\Traits\CreatedByRelationship;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Relations\BelongsTo;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Database\Eloquent\SoftDeletes;
  
  class Invoice extends BaseModel
  {
	use BootTrait, HasFactory, SoftDeletes, CreatedByRelationship;
	
	protected $fillable = [
		'client_id',
		'currency_id',
		'invoice_number',
		'recurring',
		'date',
		'due_date',
		'status_id',
		'recurring_cycle_id',
		'sub_total',
		'discount_type',
		'discount',
		'total',
		'received_amount',
		'due_amount',
		'notes',
		'terms',
		'created_by'
	];
	protected $casts = [
		'due_amount' => 'double',
	];
	
	public function status(): BelongsTo
	{
	  return $this->belongsTo(Status::class);
	}
	
	public function recurringCycle(): BelongsTo
	{
	  return $this->belongsTo(RecurringCycle::class, 'recurring_cycle_id', 'id');
	}
	
	public function client(): BelongsTo
	{
	  return $this->belongsTo(config('biller.client'));
	}
	
	public function invoiceDetails(): HasMany
	{
	  return $this->hasMany(InvoiceDetail::class);
	}
	
	public function invoiceRecurrings()
	{
	  return $this->hasMany(InvoiceRecurring::class, 'referance_invoice_id', 'id');
	}
  }
