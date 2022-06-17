<?php

namespace Database\Factories\Billar\Product;

use App\Models\Billar\Category\Category;
use App\Models\Billar\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'code' => $this->faker->numberBetween(10000, 100000),
            'category_id' => $this->faker->randomElement(Category::query()->get('id')),
            'unit_price' => $this->faker->numberBetween(100, 1000),
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s
         standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
         It has survived not only five centuries, but also the leap into electronic typesetting',
        ];
    }
}
