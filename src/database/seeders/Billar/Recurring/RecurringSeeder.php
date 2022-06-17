<?php


namespace Database\Seeders\Billar\Recurring;


use App\Models\Billar\Recurring\RecurringCycle;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class RecurringSeeder extends Seeder
{
    use DisableForeignKeys;
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        RecurringCycle::query()->truncate();
        $recurring = [
            [
                'name' => 'Monthly',
            ],
            [
                'name' => 'Quarterly',
            ],
            [
                'name' => 'Semi annually',
            ],
            [
                'name' => 'Annually',
            ],
        ];

        RecurringCycle::query()->insert($recurring);

        $this->enableForeignKeys();
    }
}