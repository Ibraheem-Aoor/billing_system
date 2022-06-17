<?php

namespace App\Filters\Billar\PaymentHistory;

use App\Filters\Billar\Traits\InvoiceClientFilterTraits;
use App\Filters\Billar\Traits\PaymentMethodFilterTraits;
use App\Filters\Core\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class PaymentHistoryFilter extends BaseFilter
{
    use InvoiceClientFilterTraits, PaymentMethodFilterTraits;

    public function search($search = null)
    {
        return $this->builder->when($search, function (Builder $builder) use ($search) {
            $builder->whereHas('invoice', function (Builder $builder) use ($search) {
                $builder->where('invoice_number', 'LIKE', "%$search%");
            });
        });
    }

    public function date($date = null)
    {
        $date = json_decode(htmlspecialchars_decode($date), true);
        return $this->builder->when($date, function (Builder $builder) use ($date) {
            $builder->whereBetween(\DB::raw('DATE(received_on)'), array_values($date));
        });
    }

    public function amountRange($value = null)
    {
        $value = json_decode(htmlspecialchars_decode($value), true);
        return $this->builder->when($value, function (Builder $builder) use ($value) {
            $builder->whereBetween('amount', array_values($value));
        });

    }

}