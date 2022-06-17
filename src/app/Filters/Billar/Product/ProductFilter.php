<?php


namespace App\Filters\Billar\Product;


use App\Filters\Billar\Traits\DateRangeFilter;
use App\Filters\Billar\Traits\NameFilterTrait;
use App\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends FilterBuilder
{
    use NameFilterTrait, DateRangeFilter;

    public function categories($ids = null)
    {
        $category = explode(',', $ids);

        $this->builder->when($ids, function (Builder $query) use ($category) {
            $query->whereHas('category', function (Builder $query) use ($category) {
                $query->whereIn('category_id', $category);
            });
        });
    }
}