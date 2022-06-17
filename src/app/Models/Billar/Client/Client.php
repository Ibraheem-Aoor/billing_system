<?php

namespace App\Models\Billar\Client;

use App\Models\Billar\Address\ClientAddress;
use App\Models\Billar\Country\Country;
use App\Models\Billar\Traits\EmailRelationshipTrait;
use App\Models\Billar\Traits\PhoneRelationshipTrait;
use App\Models\Core\Auth\User;
use App\Models\Core\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends BaseModel
{
    use HasFactory,
        EmailRelationshipTrait,
        PhoneRelationshipTrait,
        SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_number',
        'state',
        'city',
        'postal_code',
        'country_id',
        'website_url',
        'notes',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(ClientAddress::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
