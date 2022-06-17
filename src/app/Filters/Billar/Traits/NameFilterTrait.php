<?php


namespace App\Filters\Billar\Traits;


use Illuminate\Database\Eloquent\Builder;

trait NameFilterTrait
{

    public function search($search = null)
    {
        return $this->builder->when($search, function (Builder $builder) use ($search) {
            $builder->where('name', 'LIKE', "%$search%");
        });
    }
}