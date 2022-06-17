<?php

namespace Database\Seeders;

use Database\Seeders\App\NotificationChannelTableSeeder;
use Database\Seeders\App\NotificationEventTableSeeder;
use Database\Seeders\App\NotificationSettingsSeeder;
use Database\Seeders\App\NotificationTemplateSeeder;
use Database\Seeders\App\PaymentMethodTableSeeder;
use Database\Seeders\App\PermissionChildAppSeeder;
use Database\Seeders\App\SettingTableSeeder;
use Database\Seeders\Auth\PermissionRoleTableSeeder;
use Database\Seeders\Auth\TypeSeeder;
use Database\Seeders\Auth\UserRoleTableSeeder;
use Database\Seeders\Auth\UserTableSeeder;
use Database\Seeders\Billar\Country\CountrySeeder;
use Database\Seeders\Billar\Currency\CurrencySeeder;
use Database\Seeders\Billar\Recurring\RecurringSeeder;
use Database\Seeders\Builder\CustomFieldTypeSeeder;
use Database\Seeders\Status\StatusSeeder;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();
        $this->disableForeignKeys();

        $this->call(StatusSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PermissionChildAppSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(CustomFieldTypeSeeder::class);
        $this->call(NotificationChannelTableSeeder::class);
        $this->call(NotificationEventTableSeeder::class);
        $this->call(NotificationSettingsSeeder::class);
        $this->call(NotificationTemplateSeeder::class);
        $this->call(PaymentMethodTableSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(RecurringSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->enableForeignKeys();
        Model::reguard();
    }
}
