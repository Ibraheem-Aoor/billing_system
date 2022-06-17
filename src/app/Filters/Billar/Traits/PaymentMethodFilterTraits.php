<?php

namespace App\Filters\Billar\Traits;

use Illuminate\Database\Eloquent\Builder;

trait PaymentMethodFilterTraits
{
    public function paymentMethods($ids = null)
    {
        $payments = explode(',', $ids);

        $this->builder->when($ids, function (Builder $query) use ($payments) {
            $query->whereHas('paymentMethod', function (Builder $query) use ($payments) {
                $query->whereIn('payment_method_id', $payments);
            });
        });
    }
}