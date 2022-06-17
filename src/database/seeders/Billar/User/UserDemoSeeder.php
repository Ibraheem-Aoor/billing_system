<?php

namespace Database\Seeders\Billar\User;

use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDemoSeeder extends Seeder
{
    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();
        $status = Status::findByNameAndType('status_active', 'user')->id;
        $users = [
            [
                'first_name' => 'General',
                'last_name' => 'Admin',
                'email' => 'general@demo.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ],
            [
                'first_name' => 'Rosey',
                'last_name' => 'Martin',
                'email' => 'client@demo.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ],
            [
                'first_name' => 'Dylan',
                'last_name' => 'Cote',
                'email' => 'fulevyca@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Berk',
                'last_name' => 'Barber',
                'email' => 'xibe@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Leroy',
                'last_name' => 'Francis',
                'email' => 'jmilizytax@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Zephr',
                'last_name' => 'Jordan',
                'email' => 'tewugad@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Kenneth',
                'last_name' => 'Macdonald',
                'email' => 'zosalyru@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Alexandra',
                'last_name' => 'Snyder',
                'email' => 'kaqofof@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Henry',
                'last_name' => 'Snyder',
                'email' => 'nikuvy@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Jared',
                'last_name' => 'Murphy',
                'email' => 'nuciq@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => Status::findByNameAndType('status_active', 'user')->id,
                'created_at' => now()
            ], [
                'first_name' => 'Bethany',
                'last_name' => 'Schneider',
                'email' => 'nerewibowe@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Ulric',
                'last_name' => 'Brady',
                'email' => 'cohipiwo@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Basia',
                'last_name' => 'Padilla',
                'email' => 'hozajoveke@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ], [
                'first_name' => 'Michelle',
                'last_name' => 'Stein',
                'email' => 'fenapypygo@mailinator.com',
                'password' => Hash::make('123456'),
                'status_id' => $status,
                'created_at' => now()
            ]

        ];

        User::query()->insert($users);
        $this->enableForeignKeys();
    }
}
