<?php

namespace Database\Seeders\Billar\User;

use App\Models\Core\Auth\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleDemoSeeder extends Seeder
{
    
    public function run()
    {
        $users = User::query()->where('id', '!=', 1)->get()->toArray();
        foreach ($users as $user) {
            DB::table('role_user')->insert([
                'user_id' => $user['id'],
                'role_id' => 2
            ]);
        }
    }
}
