<?php

namespace App\Filters\Billar\Traits;

use Illuminate\Database\Eloquent\Builder;

trait StatusFilterTrait
{
    public function status($status = null)
    {
        if ($status) {
            $status = explode(',', $status);
            $this->builder->when($status, function (Builder $query) use ($status) {
                $query->whereHas('status', function (Builder $query) use ($status) {
                    $query->whereIn('id', $status);
                });
            });
        }
        return $this->builder;
    }
}