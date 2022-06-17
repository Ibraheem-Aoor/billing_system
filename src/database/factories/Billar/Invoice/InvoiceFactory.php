<?php


namespace Database\Factories\Billar\Invoice;

use App\Models\Billar\Currency\Currency;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\Product\Product;
use App\Models\Billar\Recurring\RecurringCycle;
use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'client_id' => $this->faker->randomElement(User::query()->where('id', '!=', 1)->get('id')),
            'currency_id' => $this->faker->randomElement(Currency::query()->get('id')),
            'invoice_number' => $this->faker->unique()->randomElement([mt_rand(100, 999)]),
            'recurring' => $this->faker->randomElement([1, 2]),
            'date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'status_id' => $this->faker->randomElement(Status::query()->where('type', 'invoice')->get('id')),
            'recurring_cycle_id' => $this->faker->randomElement(RecurringCycle::query()->get('id')),
            'sub_total' => Product::inRandomOrder()->first()->unit_price,
            'total' => Product::inRandomOrder()->first()->unit_price,
            'received_amount' => Product::inRandomOrder()->first()->unit_price,
            'due_amount' => Product::inRandomOrder()->first()->unit_price,
            'created_by' => $this->faker->randomElement(User::query()->get('id'))

        ];
    }
}