<?php


namespace App\Services\Billar\Dashboard;


use App\Filters\Billar\Dashboard\DashboardFilter;
use App\Filters\Core\BaseFilter;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\Product\Product;
use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use App\Services\Billar\ApplicationBaseService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class DashboardService extends ApplicationBaseService
{
    public $status;
    public DashboardFilter $filter;

    public function __construct(Invoice $invoice, DashboardFilter $filter)
    {
        $this->model = $invoice;
        $this->filter = $filter;
        $this->status = $this->getStatus();
    }

    public function totalClient()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('alias', 'client');
        })->where('status_id', $this->status['status_active'])
            ->count();
    }

    public function invoiceCount($status = null)
    {
        return $this->model
            ->query()
            ->filters($this->filter)
            ->when($status, function ($query) use ($status) {
                return $query->where('status_id', $status);
            })->count();
    }

    public function totalProduct()
    {
        return Product::count();
    }

    public function paymentSummation($columnName)
    {
        return $this->model
            ->query()
            ->filters($this->filter)
            ->sum($columnName);
    }

    public function paymentOverView()
    {
        return $this->model
            ->query()
            ->filters($this->filter)
            ->select(
                DB::raw('SUM(received_amount) as received_amount'),
                DB::raw('SUM(due_amount) as due_amount')
            )->get();
    }

    /**
     * @param $year
     * @return mixed
     */
    public function monthlyIncome()
    {
        return $this->model
            ->query()
            ->filters($this->filter)
            ->whereBetween('date', $this->thisYear())
            ->select(
                DB::raw('SUM(invoices.received_amount) as income'),
                DB::raw('MONTH(invoices.date) as month')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }


    private function thisYear(): array
    {
        return array(now()->startOfYear()->toDateTimeString(), now()->endOfYear()->toDateTimeString());
    }

    public function manipulateChart(object $charts): array
    {
        $monthContainer = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthContainer[Carbon::create()->month($i)->format('M')] = new stdClass();
        }
        foreach ($charts as $value) {
            $monthContainer[Carbon::create()->month($value->month)->format('M')] = $value;
        }
        return $monthContainer;
    }

    public function getStatus()
    {
        return Status::where('type', 'user')
            ->orWhere('type', 'invoice')
            ->pluck('id', 'name');
    }
}