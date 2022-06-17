<?php

namespace Database\Seeders\Billar\Currency;

use App\Models\Billar\Currency\Currency;
use App\Models\Core\Auth\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();
        $superAdmin = User::first();
        $currencies = [
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'created_by' => $superAdmin->id,
            ],
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'created_by' => $superAdmin->id,
            ],
            [
                'name' => 'Pound',
                'code' => 'GBP',
                'created_by' => $superAdmin->id,
            ],
            [
                'name' => 'Australian dollar',
                'code' => 'AUD',
                'created_by' => $superAdmin->id,
            ],
            [
                'name' => 'Canadian dollar',
                'code' => 'CAD',
                'created_by' => $superAdmin->id,
            ]
        ];

        Currency::query()->insert($currencies);
        $this->enableForeignKeys();
    }
}
