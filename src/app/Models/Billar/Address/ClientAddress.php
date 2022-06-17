<?php

namespace App\Models\Billar\Address;

use App\Models\Core\Traits\BootTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientAddress extends Model
{
    use HasFactory, BootTrait;

    protected $fillable = ['address', 'client_id'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientAddress::class);
    }
}
