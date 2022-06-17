<?php

namespace App\Models\Billar\Recurring;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecurringCycle extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name'];
}
