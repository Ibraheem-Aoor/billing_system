<?php

namespace App\Models\Billar\Tax;

use App\Models\Billar\Invoice\InvoiceDetail;
use App\Models\Core\BaseModel;
use App\Models\Core\Traits\BootTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tax extends BaseModel
{
    use HasFactory, BootTrait;

    protected $fillable = [
        'name',
        'value',
        'is_default'
    ];

    public function productDetails(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
