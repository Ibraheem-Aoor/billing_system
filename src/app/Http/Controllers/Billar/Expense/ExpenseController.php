<?php

namespace App\Http\Controllers\Billar\Expense;

use App\Filters\Billar\Expense\ExpenseFilter;
use App\Helpers\traits\DateRangeHelper;
use App\Http\Controllers\Controller;
use App\Models\Billar\Expense\Expense;
use App\Services\Billar\Expense\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function __construct(ExpenseService $expenseService, ExpenseFilter $expenseFilter)
    {
        $this->service = $expenseService;
        $this->filter = $expenseFilter;
    }

    public function index()
    {
        return $this->service
            ->filters($this->filter)
            ->with(['purpose','attachment'])
            ->paginate(\request('per_page', 15));

    }


    public function show(Expense $expense)
    {
        return $expense->load('purpose:id,name');
    }

    public function store(Request $request)
    {
        $this->service
            ->checkValidation()
            ->setAttributes($request->except('attachment'))
            ->save();

        $this->service->when($request->has('attachment'), fn(ExpenseService $service) => $service->saveAttachment($request->attachment));

        return created_responses('expense');

    }

    public function update(Request $request, Expense $expense)
    {
        $this->service
            ->setModel($expense)
            ->checkValidation()
            ->setAttributes($request->except('attachment'))
            ->save();

        $this->service->when($request->has('attachment'), fn(ExpenseService $service) => $service->saveAttachment($request->attachment));

        return updated_responses ('expense');
    }

    public function destroy(Expense $expense)
    {
        $this->service
            ->setModel($expense)
            ->deleteAttachment()
            ->deleteAttachmentData()
            ->delete();
        return deleted_responses('expense');
    }
}
