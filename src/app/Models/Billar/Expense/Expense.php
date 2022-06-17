<?php

namespace App\Models\Billar\Expense;

use App\Models\Core\BaseModel;
use App\Models\Core\File\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name','amount','reference','purpose_id','details','date'];

    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
    }

    public function attachment()
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
