<?php


namespace Database\Factories\Billar\Invoice;

use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\Invoice\InvoiceDetail;
use App\Models\Billar\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceDetailFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'invoice_id' => $this->faker->randomElement(Invoice::query()->get('id')),
            'product_id' => $this->faker->randomElement(Product::query()->get('id')),
            'quantity' => 1,
            'price' => Invoice::inRandomOrder()->first()->total,
        ];
    }
}