<?php

namespace App\Models\Billar\Traits;


use App\Models\Billar\Email\Email;

trait EmailRelationshipTrait
{
    public function email()
    {
        return $this->morphMany(Email::class, 'contextable');
    }
}
