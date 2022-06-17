<?php


namespace App\Filters\Billar\Traits;


use Illuminate\Database\Eloquent\Builder;

trait CountryFilterTrait
{
    public function countries($ids = null)
    {
        $countryId = explode(',', $ids);
        return $this->builder->when($ids, function (Builder $builder) use ($countryId) {
            $builder->whereIn('country_id', $countryId);
        });
    }

}