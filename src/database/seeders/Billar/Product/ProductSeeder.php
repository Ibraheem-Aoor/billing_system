<?php

namespace Database\Seeders\Billar\Product;

use App\Models\Billar\Category\Category;
use App\Models\Billar\Product\Product;
use Carbon\Carbon;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();
        Product::query()->truncate();
        $category = Category::query()->pluck('id')->toArray();
        $products = [
            [
                'name' => 'Voluptatum quidem labore cumque ea repudiandae debitis corrupti',
                'code' => '123456',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 5000,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Voluptas voluptatem atque hic reiciendis eius delectus reiciendis',
                'code' => '1258',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 500,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Repudiandae nemo sed eius ullam et.',
                'code' => '9874',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 3000,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Ad et recusandae rerum odit sed quisquam omnis',
                'code' => '9441',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 2000,
                'description' => '',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Quisquam aut at provident voluptas aspernatur similique.',
                'code' => '9331',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 1500,
                'description' => 'Lorem Ipsum is simply dummy text of',
                'created_at' => Carbon::now()
            ], [
                'name' => 'Neque praesentium debitis delectus quo.',
                'code' => '9221',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 1400,
                'description' => 'Lorem Ipsum is simply dummy text of',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Explicabo ut et hic temporibus qui.',
                'code' => '9111',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 1400,
                'description' => '',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Rerum eius reiciendis mollitia aut ipsum.',
                'code' => '1111',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 1300,
                'description' => '',
                'created_at' => Carbon::now()
            ], [
                'name' => 'Maxime corrupti cumque est sit aliquid aut sint omnis.',
                'code' => '1511',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 1100,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Modi iusto at quis ut eveniet ut.',
                'code' => '5011',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 100,
                'description' => '',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Corrupti veniam assumenda dolore necessitatibus delectus.',
                'code' => '5611',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 120,
                'description' => '',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Et totam qui quia enim alias.',
                'code' => '2021',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 150,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'created_at' => Carbon::now()
            ], [
                'name' => 'Aliquid animi reiciendis vel at blanditiis necessitatibus voluptatem reprehenderit.',
                'code' => '2411',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 130,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Neque excepturi odit tenetur.',
                'code' => '2911',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 1600,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Accusamus unde nesciunt aut dolores.',
                'code' => '7911',
                'category_id' => $category[array_rand($category)],
                'unit_price' => 1700,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'created_at' => Carbon::now()
            ],
        ];
        Product::query()->insert($products);
        $this->enableForeignKeys();
    }
}
