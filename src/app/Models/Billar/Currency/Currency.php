<?php

namespace App\Models\Billar\Currency;

use App\Models\Core\BaseModel;
use App\Models\Core\Traits\BootTrait;

class Currency extends BaseModel
{
    use BootTrait;

    protected $fillable = ['name', 'code', 'created_by'];
}
