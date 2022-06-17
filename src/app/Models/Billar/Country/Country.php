<?php

namespace App\Models\Billar\Country;

use App\Models\Billar\Client\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
