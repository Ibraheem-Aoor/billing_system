<?php

namespace App\Http\Controllers\Billar\Support;

use App\Helpers\traits\DateRangeHelper;
use App\Http\Controllers\Controller;
use App\Models\App\PaymentMethods\PaymentMethod;
use App\Models\Billar\Address\ClientAddress;
use App\Models\Billar\Category\Category;
use App\Models\Billar\Currency\Currency;
use App\Models\Billar\Expense\Expense;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\PaymentHistory\PaymentHistory;
use App\Models\Billar\Recurring\RecurringCycle;
use App\Models\Billar\Tax\Tax;
use App\Models\Core\Auth\Role;
use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use Illuminate\Support\Facades\DB;

class SupportApiController extends Controller
{

    use DateRangeHelper;

//    public function deleteAddress(ClientAddress $clientAddress)
//    {
//        $clientAddress->delete();
//        return deleted_responses('address');
//    }

    public function recurringCycle()
    {
        return RecurringCycle::select('id', 'name')->get();
    }

    public function invoice()
    {
        return Invoice::select('id', 'invoice_number')->get();
    }

    public function paymentMethod()
    {
        $activePaymentMethod = Status::findByNameAndType('status_active', 'payment_method')->id;

        return PaymentMethod::query()->when(auth()->user()->isAppAdmin(), function ($query) {
            $query->whereNotIn('alias', ['paypal', 'stripe']);
        })->when(!auth()->user()->isAppAdmin(), function ($query) {
            $query->whereIn('alias', ['paypal', 'stripe']);
        })->where('status_id', '=', $activePaymentMethod)
            ->select('id', 'name', 'alias')
            ->get();
    }

    public function clientUser()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Client');
        })->select('id', 'first_name', 'last_name')
            ->get();
    }

    public function currency()
    {
        return Currency::select('id', 'name')->get();
    }

    public function category()
    {
        return Category::select('id', 'name')->get();
    }

    public function invoiceNumber()
    {
        return Invoice::withTrashed()->select('id')->orderByDesc('id')->first();
    }

    public function taxes()
    {
        return Tax::select('id', 'name', 'value')->get();
    }

    public function roles()
    {
        return Role::with('users:id,first_name,last_name,email', 'users.profilePicture')
            ->whereNull('alias')
            ->orderBy('id')
            ->get();
    }

    public function invoiceSummation()
    {
        return Invoice::when(!auth()->user()->isAppAdmin(), function ($query) {
            $query->where('client_id', auth()->id());
        })->select(
            DB::raw('SUM(total) as total_amount'),
            DB::raw('SUM(received_amount) as paid_amount'),
            DB::raw('SUM(due_amount) as due_amount')
        )->first();
    }

    public function paymentSummation()
    {
        return PaymentHistory::whereHas('invoice', function ($query) {
            $query->when(!auth()->user()->can('show_all_data'), function ($query) {
                $query->where('client_id', auth()->id());
            });
        })->sum('amount');
    }

    public function getSummery(): array
    {
        $expenses = Expense::query()->select('id', 'amount', 'date')->get();
        $total_expense = $expenses->sum('amount');
        $month_expense = $expenses->whereBetween('date', $this->getStartAndEndOf('thisMonth'))->sum('amount');
        $week_expense = $expenses->whereBetween('date', $this->getStartAndEndOf('thisWeek'))->sum('amount');
        $today_expense = $expenses->where('date', today()->toDateString())->sum('amount');

        return [
            'totalExpense' => $total_expense,
            'monthExpense' => $month_expense,
            'weekExpense' => $week_expense,
            'todayExpense' => $today_expense,
        ];
    }
}
