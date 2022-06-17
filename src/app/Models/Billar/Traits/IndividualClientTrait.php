<?php

namespace App\Models\Billar\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IndividualClientTrait
{
    public function clientRoleAccess($value = 'no')
    {
        $this->builder->when($value == 'no', function (Builder $query) {
            $query->where('client_id', auth()->id());
        });
    }
}