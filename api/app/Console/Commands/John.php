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
        //$name = $this->confirm('Do you wish to continue?');
        $name = $this->choice('What is your name?', ['Taylor', 'Dayle'], $default);
        //$name = $this->anticipate('What is your name?', ['John', 'Dayle']);
        print_r($name);
        //print_r($userId);
        /*if ($name) {
            print_r($userId);
            dd($option);
        } else {
            print('nono');
        }*/
    }
}
