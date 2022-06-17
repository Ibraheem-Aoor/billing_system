<?php

namespace Database\Seeders\Billar\Invoice;

use App\Models\Billar\Currency\Currency;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\Invoice\InvoiceDetail;
use App\Models\Billar\Recurring\RecurringCycle;
use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    use DisableForeignKeys;


    public function run()
    {
        $this->disableForeignKeys();
        $user = User::query()->where('id', '!=', 1)->pluck('id')->toArray();
        $recurringCycle = RecurringCycle::query()->pluck('id')->toArray();
        $createdBy = User::query()->pluck('id')->toArray();

        $invoice = [
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 1,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d'),
                'due_date' => date('Y-m-d', strtotime('+10 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 5500, // 1-2
                'total' => 5500,
                'received_amount' => 500,
                'due_amount' => 5000,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 2,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-10 day')),
                'due_date' => date('Y-m-d', strtotime('+10 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 3000, //3
                'total' => 3000,
                'received_amount' => 1000,
                'due_amount' => 2000,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 3,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-20 day')),
                'due_date' => date('Y-m-d', strtotime('+30 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 5000, //3-4
                'total' => 5000,
                'received_amount' => 2500,
                'due_amount' => 2500,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 4,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-5 day')),
                'due_date' => date('Y-m-d', strtotime('+5 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 2900, //5-6
                'total' => 2900,
                'received_amount' => 2500,
                'due_amount' => 400,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 5,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-2 day')),
                'due_date' => date('Y-m-d', strtotime('+7 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 2700, // 7-8
                'total' => 2700,
                'received_amount' => 100,
                'due_amount' => 2600,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 6,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-3 day')),
                'due_date' => date('Y-m-d', strtotime('+15 day')),
                'status_id' => 6,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 1100, //9
                'total' => 1100,
                'received_amount' => 0,
                'due_amount' => 1100,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 7,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-6 day')),
                'due_date' => date('Y-m-d', strtotime('+10 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 220, // 10-11
                'total' => 220,
                'received_amount' => 20,
                'due_amount' => 200,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 8,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d'),
                'due_date' => date('Y-m-d', strtotime('+10 day')),
                'status_id' => 8,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 280, // 12-13
                'total' => 280,
                'received_amount' => 280,
                'due_amount' => 0,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 9,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-21 day')),
                'due_date' => date('Y-m-d', strtotime('+22 day')),
                'status_id' => 9,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 1600, //14
                'total' => 1600,
                'received_amount' => 0,
                'due_amount' => 0,
                'created_by' => $createdBy[array_rand($createdBy)]
            ], [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 10,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d'),
                'due_date' => date('Y-m-d', strtotime('+10 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 3300, //14-15
                'total' => 3300,
                'received_amount' => 300,
                'due_amount' => 3000,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 11,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('3 day')),
                'due_date' => date('Y-m-d', strtotime('+10 day')),
                'status_id' => 8,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 2800, // 6-7
                'total' => 2800,
                'received_amount' => 2800,
                'due_amount' => 0,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 12,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-14 day')),
                'due_date' => date('Y-m-d', strtotime('+2 day')),
                'status_id' => 6,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 2900, // 15-2
                'total' => 2900,
                'received_amount' => 0,
                'due_amount' => 2900,
                'created_by' => $createdBy[array_rand($createdBy)]
            ], [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 13,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-16 day')),
                'due_date' => date('Y-m-d', strtotime('+5 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 270, // 10-11
                'total' => 270,
                'received_amount' => 70,
                'due_amount' => 200,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 14,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d'),
                'due_date' => date('Y-m-d', strtotime('+10 day')),
                'status_id' => 7,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 1400, //11-12-13
                'total' => 1400,
                'received_amount' => 400,
                'due_amount' => 1000,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],
            [
                'client_id' => $user[array_rand($user)],
                'invoice_number' => 15,
                'recurring' => rand(0, 1),
                'date' => date('Y-m-d', strtotime('-6 day')),
                'due_date' => date('Y-m-d', strtotime('+17 day')),
                'status_id' => 8,
                'recurring_cycle_id' => $recurringCycle[array_rand($recurringCycle)],
                'sub_total' => 3600, //14-4
                'total' => 3600,
                'received_amount' => 3600,
                'due_amount' => 0,
                'created_by' => $createdBy[array_rand($createdBy)]
            ],

        ];

        Invoice::query()->insert($invoice);


        $invoiceDetails = [
            [
                'invoice_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 5000,
            ],
            [
                'invoice_id' => 1,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 500,
            ],
            [
                'invoice_id' => 2,
                'product_id' => 3,
                'quantity' => 1,
                'price' => 3000,
            ],
            [
                'invoice_id' => 3,
                'product_id' => 4,
                'quantity' => 1,
                'price' => 2000,
            ],
            [
                'invoice_id' => 4,
                'product_id' => 5,
                'quantity' => 1,
                'price' => 1500,
            ],
            [
                'invoice_id' => 4,
                'product_id' => 6,
                'quantity' => 1,
                'price' => 1400,
            ],
            [
                'invoice_id' => 5,
                'product_id' => 7,
                'quantity' => 1,
                'price' => 1400,
            ],
            [
                'invoice_id' => 5,
                'product_id' => 8,
                'quantity' => 1,
                'price' => 1300,
            ],
            [
                'invoice_id' => 6,
                'product_id' => 9,
                'quantity' => 1,
                'price' => 1100,
            ],
            [
                'invoice_id' => 7,
                'product_id' => 10,
                'quantity' => 1,
                'price' => 100,
            ],
            [
                'invoice_id' => 7,
                'product_id' => 11,
                'quantity' => 1,
                'price' => 120,
            ],
            [
                'invoice_id' => 8,
                'product_id' => 12,
                'quantity' => 1,
                'price' => 150,
            ],
            [
                'invoice_id' => 8,
                'product_id' => 13,
                'quantity' => 1,
                'price' => 130,
            ],
            [
                'invoice_id' => 9,
                'product_id' => 14,
                'quantity' => 1,
                'price' => 1600,
            ],
            [
                'invoice_id' => 10,
                'product_id' => 14,
                'quantity' => 1,
                'price' => 1600,
            ], [
                'invoice_id' => 10,
                'product_id' => 15,
                'quantity' => 1,
                'price' => 1700,
            ],
            [
                'invoice_id' => 11,
                'product_id' => 6,
                'quantity' => 1,
                'price' => 1400,
            ],
            [
                'invoice_id' => 11,
                'product_id' => 7,
                'quantity' => 1,
                'price' => 1400,
            ], [
                'invoice_id' => 12,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 500,
            ],
            [
                'invoice_id' => 12,
                'product_id' => 15,
                'quantity' => 1,
                'price' => 1700,
            ], [
                'invoice_id' => 13,
                'product_id' => 10,
                'quantity' => 1,
                'price' => 100,
            ], [
                'invoice_id' => 13,
                'product_id' => 11,
                'quantity' => 1,
                'price' => 120,
            ], [
                'invoice_id' => 14,
                'product_id' => 11,
                'quantity' => 1,
                'price' => 120,
            ], [
                'invoice_id' => 14,
                'product_id' => 12,
                'quantity' => 1,
                'price' => 150,
            ], [
                'invoice_id' => 14,
                'product_id' => 13,
                'quantity' => 1,
                'price' => 130,
            ], [
                'invoice_id' => 15,
                'product_id' => 14,
                'quantity' => 1,
                'price' => 1600,
            ], [
                'invoice_id' => 15,
                'product_id' => 4,
                'quantity' => 1,
                'price' => 2000,
            ],
        ];

        InvoiceDetail::query()->insert($invoiceDetails);

    }
}
