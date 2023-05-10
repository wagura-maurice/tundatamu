<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Debug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'debugging the application mechanics';

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
            return Command::SUCCESS;
        } catch (\Throwable $th) {
            throw $th;
            // eThrowable(get_class($this), $this->description.': \n'.'error message: '.$th->getMessage());
            return Command::FAILURE;
        }
    }
}
