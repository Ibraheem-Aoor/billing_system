<?php


namespace App\Models\Billar\User;

use App\Models\Billar\Client\Client;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Core\Auth\User as CoreUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends CoreUser
{
    public function clients(): HasOne
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }
}