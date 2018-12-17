<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class John extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name {user*} {--id=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'First';

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
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument();
        $option = $this->option('id');
        $default = 0;
        $name = $this->ask('What is your name?');
        $date = $this->ask('Please enter the date');

    }
}
