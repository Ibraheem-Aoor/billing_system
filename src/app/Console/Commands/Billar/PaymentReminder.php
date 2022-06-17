<?php

namespace App\Console\Commands\Billar;

use App\Jobs\PaymentReminderJob;
use App\Mail\Billar\PaymentReminderMail;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Core\Status;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoice due date payment reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(7);

        $status = Status::findByNameAndType('status_paid', 'invoice')->id;

        $invoices = Invoice::with('client:id,first_name,last_name,email')
            ->where('status_id', '!=', $status)
            ->whereBetween('due_date', [$startDate, $endDate])
            ->get();

        foreach ($invoices as $invoice) {
            PaymentReminderJob::dispatch($invoice)->onQueue('high');
        }
    }
}
