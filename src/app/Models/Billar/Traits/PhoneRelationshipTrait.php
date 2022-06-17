<?php

namespace App\Models\Billar\Traits;


use App\Models\Billar\Phone\Phone;

trait PhoneRelationshipTrait
{
    public function phone()
    {
        return $this->morphMany(Phone::class, 'contextable');
    }
}
