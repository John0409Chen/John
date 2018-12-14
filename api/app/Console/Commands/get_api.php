<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ApiRepository;
use App\Services\GetApiService;
use App\Jobs\Saveapi;
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
        $getApi = new GetApiService($this->apiRepository);
        $data = $getApi->getApi(0);
        $getApi->getAllData($data);
    }
}
