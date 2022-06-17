<?php

namespace App\Filters\Billar\Expense;

use App\Filters\Billar\Traits\DateRangeFilter;
use App\Filters\Billar\Traits\NameFilterTrait;
use App\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Builder;

class ExpenseFilter extends FilterBuilder
{
    use NameFilterTrait, DateRangeFilter;

    public function expensePurpose($ids = null)
    {
        $purposeId = explode(',', $ids);
        $this->builder->when($ids, function (Builder $builder) use ($purposeId) {
            $builder->whereIn('purpose_id', $purposeId);
        });
    }
}