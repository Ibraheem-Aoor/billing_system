<?php

namespace Database\Factories\Billar\Client;


use App\Models\Billar\Client\Client;
use App\Models\Billar\Country\Country;
use App\Models\Core\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::query()->where('id', '!=', 1)->get('id')),
            'client_number' => $this->faker->unique()->randomNumber(),
            'state' => $this->faker->state,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'country_id' => $this->faker->randomElement(Country::query()->get('id')),

        ];
    }
}
