<?php

namespace App\Models\Billar\Phone;

use App\Models\Core\Traits\BootTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory, BootTrait;

    protected $fillable = ['value'];

    protected static $logAttributes = [
        'value', 'contextable'
    ];

    public function contextable()
    {
        return $this->morphTo();
    }
}
