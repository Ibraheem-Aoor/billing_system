<?php

namespace App\Console\Commands;

use Database\Seeders\Billar\DemoDataSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DemoSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This custom command will generate demo data for your application to test';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Artisan::call('db:seed', [
            '--class' => DemoDataSeeder::class,
            '--force' => true
        ]);

        $this->info('Dummy data seeded successfully.');
    }
}
