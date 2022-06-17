<?php

namespace Database\Seeders\Billar\Payment;

use App\Models\Billar\PaymentHistory\PaymentHistory;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class PaymentHistorySeeder extends Seeder
{
    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();

        $payments = [
            [
                'invoice_id' => 14,
                'payment_method_id' => 1,
                'received_on' => date('Y-m-d', strtotime('-5 day')),
                'amount' => 400,
                'note' => '',
                'created_by' => 1
            ],
            [
                'invoice_id' => 13,
                'payment_method_id' => 1,
                'received_on' => date('Y-m-d', strtotime('-5 day')),
                'amount' => 70,
                'note' => '',
                'created_by' => 1
            ],
            [
                'invoice_id' => 7,
                'payment_method_id' => 1,
                'received_on' => date('Y-m-d', strtotime('-20 day')),
                'amount' => 20,
                'note' => '',
                'created_by' => 1
            ],
            [
                'invoice_id' => 5,
                'payment_method_id' => 1,
                'received_on' => date('Y-m-d', strtotime('-15 day')),
                'amount' => 100,
                'note' => '',
                'created_by' => 1
            ], [
                'invoice_id' => 1,
                'payment_method_id' => 1,
                'received_on' => date('Y-m-d'),
                'amount' => 500,
                'note' => '',
                'created_by' => 1
            ],[
                'invoice_id' => 2,
                'payment_method_id' => 1,
                'received_on' => date('Y-m-d', strtotime('-11 day')),
                'amount' => 1000,
                'note' => '',
                'created_by' => 1
            ],[
                'invoice_id' => 3,
                'payment_method_id' => 1,
                'received_on' => date('Y-m-d'),
                'amount' => 2500,
                'note' => '',
                'created_by' => 1
            ],[
                'invoice_id' => 4,
                'payment_method_id' => 1,
                'received_on' => date('Y-m-d', strtotime('-6 day')),
                'amount' => 2500,
                'note' => '',
                'created_by' => 1
            ],
        ];

        PaymentHistory::query()->insert($payments);
    }
}
