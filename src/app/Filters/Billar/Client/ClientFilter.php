<?php


namespace App\Filters\Billar\Client;


use App\Filters\Billar\Traits\CountryFilterTrait;
use App\Filters\Billar\Traits\DateRangeFilter;
use App\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ClientFilter extends FilterBuilder
{
    use DateRangeFilter, CountryFilterTrait;

    public function search($search = null)
    {
        return $this->builder->when($search, function (Builder $builder) use ($search) {
            $builder->whereHas('user', function (Builder $builder) use ($search) {
                $builder->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhereRaw(DB::raw('CONCAT(`first_name`, " ", `last_name`) LIKE ?'), ["%$search%"]);
            });

        });
    }
}