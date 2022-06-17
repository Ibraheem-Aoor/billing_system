<?php
  
  namespace App\Console\Commands\Billar;
  
  use App\Jobs\InvoiceRecurringJob;
  use Carbon\Carbon;
  use Illuminate\Console\Command;
  
  class InvoiceRecurringCommand extends Command
  {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'invoice:recurring';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	  parent::__construct();
	}
	
	
	public function handle()
	{
	  $invoice = \App\Models\Billar\Invoice\Invoice::query()
		  ->with(['recurringCycle:id,name', 'invoiceRecurrings'])
		  ->where('recurring', 1)
		  ->get();
	  
	  $invoice->each(function ($item) {
		
		if ($item->recurringCycle) {
		  if ($item->recurringCycle->name == 'Monthly') {
			$invoiceRecurring = $this->invoiceRecurringQuery($item,
				Carbon::today()->addMonth()->format('Y'),
				Carbon::today()->addMonth()->format('m'));
			
			if (!$invoiceRecurring) {
			  $date = Carbon::createFromFormat('Y-m-d', $item->date)->addMonth();
			  $dueDate = Carbon::createFromFormat('Y-m-d', $item->date)
				  ->addMonth()
				  ->addDays(7);
			  
			  $recurringInvoice = $this->store($item, $date, $dueDate);
			  
			  InvoiceRecurringJob::dispatch($recurringInvoice)->onQueue('high');
			  
			}
		  } elseif ($item->recurringCycle->name == 'Quarterly') {
		  
			$invoiceRecurring = $this->invoiceRecurringQuery($item,
				Carbon::today()->addMonths(3)->format('Y'),
				Carbon::today()->addMonths(3)->format('m'));
			if (!$invoiceRecurring) {
			  
			  $date = Carbon::createFromFormat('Y-m-d', $item->date)->addMonths(3);
			  $dueDate = Carbon::createFromFormat('Y-m-d', $item->date)->addMonths(3)
				  ->addDays(7);
			  
			  $recurringInvoice = $this->store($item, $date, $dueDate);
			  InvoiceRecurringJob::dispatch($recurringInvoice)->onQueue('high');
			  
			}
			
		  } elseif ($item->recurringCycle->name == 'Semi annually') {
		  
			$invoiceRecurring = $this->invoiceRecurringQuery($item,
				Carbon::today()->addMonths(6)->format('Y'),
				Carbon::today()->addMonths(6)->format('m'));
			if (!$invoiceRecurring) {
			  $date = Carbon::createFromFormat('Y-m-d', $item->date)->addMonths(6);
			  $dueDate = Carbon::createFromFormat('Y-m-d', $item->date)->addMonths(6)
				  ->addDays(7);
			  
			  $recurringInvoice = $this->store($item, $date, $dueDate);
			  InvoiceRecurringJob::dispatch($recurringInvoice)->onQueue('high');
			  
			}
			
		  } else {
		  
			$invoiceRecurring = $this->invoiceRecurringQuery($item,
				Carbon::today()->addYear()->format('Y'),
				Carbon::today()->addYear()->format('m'));
			if (!$invoiceRecurring) {
			  
			  $date = Carbon::createFromFormat('Y-m-d', $item->date)->addYear();
			  $dueDate = Carbon::createFromFormat('Y-m-d', $item->date)->addYear()
				  ->addDays(7);
			  
			  $recurringInvoice = $this->store($item, $date, $dueDate);
			  InvoiceRecurringJob::dispatch($recurringInvoice)->onQueue('high');
			}
			
		  }
		  
		}
	  });
	}
	
	protected function invoiceRecurringQuery($item, $year, $month)
	{
	  return $item->invoiceRecurrings()
		  ->whereYear('recurring_date', $year)
		  ->whereMonth('recurring_date', $month)
		  ->orderBy('recurring_date', 'desc')
		  ->first();
	}
	
	protected function store($item, $date, $dueDate)
	{
	  $create = $item->create(array_merge($item->toArray(), [
			  'invoice_number' => "{$item->id}-re-" . rand(44444, 66666),
			  'recurring' => 3,
			  'date' => $date,
			  'due_date' => $dueDate,
			  'status_id' => \App\Models\Core\Status::findByNameAndType('status_unpaid', 'invoice')->id,
			  'received_amount' => 0,
			  'total' => $item->total
		  ])
	  );
	  
	  $create->invoiceDetails()->createMany($item->invoiceDetails->toArray());
	  
	  $item->invoiceRecurrings()->create([
		  'invoice_id' => $create->id,
		  'recurring_date' => Carbon::today()
			  ->addMonth()
			  ->format('Y-m-d')
	  ]);
	}
  }
