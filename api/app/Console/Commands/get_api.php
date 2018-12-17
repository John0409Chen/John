<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ApiRepository;
use App\Services\GetApiService;
use App\Jobs\Saveapi;
use \Exception;

class Get_api extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test get api info';

    /** @var  ApiRepository 注入的ApiRepository */
    protected $apiRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ApiRepository $apiRepository)
    {
        parent::__construct();
        $this->apiRepository = $apiRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        try {
            $date = $this->ask('Please enter the date');
            if (date('Y-m-d', strtotime($date)) !== $date) {
                throw new Exception('the date is not correct, ex: Y-m-d');
            }
            $start = $this->ask('Please enter the start time');
            if (date('H:i:s', strtotime($start)) !== $start) {
                throw new Exception('the start time is not correct, ex: H:i:s');
            }
            $end = $this->ask('Please enter the end time');
            if (date('H:i:s', strtotime($end)) !== $end) {
                throw new Exception('the end time is not correct, ex: H:i:s');
            }
            $dateStart = $date. 'T'. $start;
            $dateEnd   = $date. 'T'. $end;
            $getApi    = new GetApiService($this->apiRepository);
            $getApi->insertAllData($dateStart, $dateEnd);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
