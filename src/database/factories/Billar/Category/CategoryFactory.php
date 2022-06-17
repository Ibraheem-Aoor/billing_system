<?php

namespace Database\Factories\Billar\Category;

use App\Models\Billar\Category\Category;
use App\Models\Core\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence($nbWords = 3, $variableNbWords = true),
            'created_by' => $this->faker->randomElement(User::query()->get('id'))
        ];
    }
}
