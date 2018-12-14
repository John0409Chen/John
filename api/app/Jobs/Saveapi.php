<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\ApiRepository;

class Saveapi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var  ApiRepository 注入的ApiRepository */
    protected $apiRepository;
    protected $apiData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($apiData)
    {
        $this->apiData = $apiData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ApiRepository $apiRepository)
    {
        $dataId = array();
        $dataBox = array();
        $this->apiRepository = $apiRepository;
        foreach ($this->apiData as $value) {
            $dataId[] = $value['api_id'];
        }

        $resultId = $this->apiRepository->apiSelect($dataId);
        $lost = array_diff($dataId, $resultId);

        if (!empty($lost)) {
            foreach ($lost as $value) {
                $lostId = array_search($value, array_column($this->apiData, 'api_id'));
                $dataBox[] = $this->apiData[$lostId];
            }
            $this->apiRepository->apiInsert($dataBox);
        }
    }
}
