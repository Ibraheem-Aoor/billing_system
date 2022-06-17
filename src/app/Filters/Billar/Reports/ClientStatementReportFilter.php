<?php


namespace App\Filters\Billar\Reports;


use App\Filters\Billar\Traits\ClientFilterTraits;
use App\Filters\Billar\Traits\InvoiceNumberFilterTrait;
use App\Filters\FilterBuilder;
use App\Models\Billar\Traits\IndividualClientTrait;
use Illuminate\Database\Eloquent\Builder;

class ClientStatementReportFilter extends FilterBuilder
{
    use ClientFilterTraits, InvoiceNumberFilterTrait, IndividualClientTrait;

    public function date($date = null)
    {
        $date = json_decode(htmlspecialchars_decode($date), true);
        $this->builder->when($date, function (Builder $builder) use ($date) {
            $builder->whereBetween(\DB::raw('DATE(date)'), array_values($date));
        });
    }

}