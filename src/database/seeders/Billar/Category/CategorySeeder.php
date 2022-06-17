<?php

namespace Database\Seeders\Billar\Category;

use App\Models\Billar\Category\Category;
use App\Models\Core\Auth\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();
        $user = User::first()->id;
        $categories = [
            [
                'name' => 'Information Technology',
                'created_by' => $user
            ],
            [
                'name' => 'Design',
                'created_by' => $user
            ], [
                'name' => 'Performing Arts & Entertainment',
                'created_by' => $user
            ], [
                'name' => 'Creative Services',
                'created_by' => $user
            ], [
                'name' => 'Government Services',
                'created_by' => $user
            ], [
                'name' => 'Non-profit Services',
                'created_by' => $user
            ], [
                'name' => 'Education & Childcare',
                'created_by' => $user
            ], [
                'name' => 'Laptop',
                'created_by' => $user
            ], [
                'name' => 'Desktop',
                'created_by' => $user
            ],[
                'name' => 'Microwave-oven',
                'created_by' => $user
            ],[
                'name' => 'Smart-phone',
                'created_by' => $user
            ],[
                'name' => 'Speaker',
                'created_by' => $user
            ],[
                'name' => 'Automotive Batteries',
                'created_by' => $user
            ],[
                'name' => 'Automotive Tires',
                'created_by' => $user
            ],[
                'name' => 'Wealth Management',
                'created_by' => $user
            ],
        ];
        Category::query()->insert($categories);
        $this->enableForeignKeys();
    }
}
