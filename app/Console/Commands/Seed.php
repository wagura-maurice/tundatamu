<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seed the applications main database tables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // logic for looping database tables though Orange hill's iseed commands.
            Artisan::call('iseed settings --force');
            // optional
            Artisan::call('iseed communication_categories,counties --force');

            return Command::SUCCESS;
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $this->description.': \n'.'error message: '.$th->getMessage());

            return Command::FAILURE;
        }
    }
}
