<?php

namespace App\Filters\Billar\Traits;

use Illuminate\Database\Eloquent\Builder;

trait InvoiceNumberFilterTrait
{
    public function search($search = null)
    {
        return $this->builder->when($search, function (Builder $builder) use ($search) {
            $builder->where('invoice_number', 'LIKE', "%$search%");
        });
    }
}