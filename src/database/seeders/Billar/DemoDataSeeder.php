<?php

namespace Database\Seeders\Billar;

use Database\Seeders\Billar\Category\CategorySeeder;
use Database\Seeders\Billar\Client\ClientSeeder;
use Database\Seeders\Billar\Invoice\InvoiceSeeder;
use Database\Seeders\Billar\Payment\PaymentHistorySeeder;
use Database\Seeders\Billar\Product\ProductSeeder;
use Database\Seeders\Billar\User\UserDemoSeeder;
use Database\Seeders\Billar\User\UserRoleDemoSeeder;
use Database\Seeders\Traits\ConsoleMessageTrait;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys, ConsoleMessageTrait;

    public function run()
    {
        Model::unguard();
        $this->disableForeignKeys();
        $this->call(UserDemoSeeder::class);
        $this->seededMessage(new UserDemoSeeder());
        $this->call(UserRoleDemoSeeder::class);
        $this->seededMessage(new UserRoleDemoSeeder());
        $this->call(CategorySeeder::class);
        $this->seededMessage(new CategorySeeder());
        $this->call(ProductSeeder::class);
        $this->seededMessage(new ProductSeeder());
        $this->call(ClientSeeder::class);
        $this->seededMessage(new ClientSeeder());
        $this->call(InvoiceSeeder::class);
        $this->seededMessage(new InvoiceSeeder());
        $this->call(PaymentHistorySeeder::class);
        $this->seededMessage(new PaymentHistorySeeder());

        $this->enableForeignKeys();
        Model::reguard();
    }
}
