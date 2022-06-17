<?php

namespace App\Filters\Billar\Invoice;

use App\Filters\Billar\Traits\ClientFilterTraits;
use App\Filters\Billar\Traits\InvoiceNumberFilterTrait;
use App\Filters\Billar\Traits\StatusFilterTrait;
use App\Filters\Core\BaseFilter;
use App\Models\Billar\Traits\IndividualClientTrait;
use Illuminate\Database\Eloquent\Builder;

class InvoiceFilter extends BaseFilter
{
    use StatusFilterTrait, ClientFilterTraits, InvoiceNumberFilterTrait, IndividualClientTrait;

    public function date($date = null)
    {
        $date = json_decode(htmlspecialchars_decode($date), true);
        $this->builder->when($date, function (Builder $builder) use ($date) {
            $builder->whereBetween(\DB::raw('DATE(date)'), array_values($date));
        });
    }

    public function due($dueDate = null)
    {
        $dueDate = json_decode(htmlspecialchars_decode($dueDate), true);
        $this->builder->when($dueDate, function (Builder $builder) use ($dueDate) {
            $builder->whereBetween(\DB::raw('DATE(due_date)'), array_values($dueDate));
        });
    }

    public function amountRange($value = null)
    {
        $value = json_decode(htmlspecialchars_decode($value), true);
        return $this->builder->when($value, function (Builder $builder) use ($value) {
            $builder->whereBetween('sub_total', array_values($value));
        });

    }

    public function paidRange($value = null)
    {
        $value = json_decode(htmlspecialchars_decode($value), true);
        return $this->builder->when($value, function (Builder $builder) use ($value) {
            $builder->whereBetween('received_amount', array_values($value));
        });
    }

    public function dueRange($value = null)
    {
        $value = json_decode(htmlspecialchars_decode($value), true);
        return $this->builder->when($value, function (Builder $builder) use ($value) {
            $builder->whereBetween('due_amount', array_values($value));
        });

    }
}