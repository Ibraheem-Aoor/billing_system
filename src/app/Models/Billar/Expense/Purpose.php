<?php

namespace App\Models\Billar\Expense;

use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purpose extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description'];
}
