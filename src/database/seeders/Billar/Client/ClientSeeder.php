<?php

namespace Database\Seeders\Billar\Client;

use App\Models\Billar\Client\Client;
use App\Models\Billar\Country\Country;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{

    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();
        $country = Country::query()->pluck('id')->toArray();

        $clients = [
            [
                'user_id' => 2,
                'client_number' => random_int(100000, 999999),
                'state' => 'South Dakota',
                'city' => 'Port Lavadaborough',
                'postal_code' => '92818',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ],
            [
                'user_id' => 3,
                'client_number' => random_int(100000, 999999),
                'state' => 'New Jersey',
                'city' => 'Leschshire',
                'postal_code' => '9818',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ],
            [
                'user_id' => 4,
                'client_number' => random_int(100000, 999999),
                'state' => 'Washington',
                'city' => 'Kosschester',
                'postal_code' => '13609',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ],
            [
                'user_id' => 5,
                'client_number' => random_int(100000, 999999),
                'state' => 'Connecticut',
                'city' => 'New Opal',
                'postal_code' => '37299',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 6,
                'client_number' => random_int(100000, 999999),
                'state' => 'Wyoming',
                'city' => 'Cartwrightfurt',
                'postal_code' => '66211',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 7,
                'client_number' => random_int(100000, 999999),
                'state' => 'Minnesota',
                'city' => 'Lilianberg',
                'postal_code' => '32529',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 8,
                'client_number' => random_int(100000, 999999),
                'state' => 'Vermont',
                'city' => 'Astridfort',
                'postal_code' => '14683',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 9,
                'client_number' => random_int(100000, 999999),
                'state' => 'District of Columbia',
                'city' => 'East Francescoville',
                'postal_code' => '1683',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 9,
                'client_number' => random_int(100000, 999999),
                'state' => 'North Dakota',
                'city' => 'Baronport',
                'postal_code' => '1783',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 10,
                'client_number' => random_int(100000, 999999),
                'state' => 'Arkansas',
                'city' => 'Krajcikburgh',
                'postal_code' => '27083',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 11,
                'client_number' => random_int(100000, 999999),
                'state' => 'Vermont',
                'city' => 'North Amira',
                'postal_code' => '58083',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 12,
                'client_number' => random_int(100000, 999999),
                'state' => 'Kansas',
                'city' => 'North Lanefort',
                'postal_code' => '45621',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 13,
                'client_number' => random_int(100000, 999999),
                'state' => 'Illinois',
                'city' => 'Ryantown',
                'postal_code' => '75621',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 14,
                'client_number' => random_int(100000, 999999),
                'state' => 'Michigan',
                'city' => 'Gulgowskitown',
                'postal_code' => '89412',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ], [
                'user_id' => 15,
                'client_number' => random_int(100000, 999999),
                'state' => 'Utah',
                'city' => 'Rutherfordmouth',
                'postal_code' => '99412',
                'country_id' => $country[array_rand($country)],
                'created_at' => now()
            ],
        ];

        Client::query()->insert($clients);
        $this->enableForeignKeys();

    }
}
