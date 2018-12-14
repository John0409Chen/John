<?php

namespace App\Services;
ini_set('memory_limit', '-1');
use App\Repositories\ApiRepository;
use App\Jobs\Saveapi;

class GetApiService
{
    /** @var  ApiRepository 注入的ApiRepository */

    protected $apiRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(ApiRepository $apiRepository)
    {
        //parent::__construct();
        $this->apiRepository = $apiRepository;
    }

    /**
     * 取得資料
     * @param
     */

    public function getApi($num)
    {
        // 初始化curl
        $urlData = curl_init();
        // 設置取得目標url
        $url = 'http://train.rd6/?start=2018-12-07T10:11:11&end=2018-12-07T10:12:00&from='.$num;
        // 設定url屬性
        curl_setopt($urlData, CURLOPT_URL, $url);
        curl_setopt($urlData, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($urlData);
        $data   = json_decode($output, true);
        curl_close($urlData);
        return $data;
    }

    public function getAllData($data)
    {
        $apiTotal  = $data['hits']['total'];
        $times  = ceil($apiTotal / 10000);
        for ($i = 0; $i < $times; $i++) {
            if ($i !== 0) {
                $fromNumber = $i * 10000;
                $data = $this->getApi($fromNumber);
            }
            $this->createData($data['hits']['hits']);
        }
    }

    public function createData($data)
    {
        $apiData = array();
        //$dataBox = array();
        foreach ($data as $key => $value) {
            $index          = $data[$key]['_index'];
            $type           = $data[$key]['_type'];
            $api_id         = $data[$key]['_id'];
            $score          = $data[$key]['_score'];
            $server_name    = $data[$key]['_source']['server_name'];
            $remote         = $data[$key]['_source']['remote'];
            $route          = $data[$key]['_source']['route'];
            $route_path     = $data[$key]['_source']['route_path'];
            $request_method = $data[$key]['_source']['request_method'];
            $user           = $data[$key]['_source']['user'];
            $http_args      = $data[$key]['_source']['http_args'];
            $log_id         = $data[$key]['_source']['log_id'];
            $status         = $data[$key]['_source']['status'];
            $size           = $data[$key]['_source']['size'];
            $referer        = $data[$key]['_source']['referer'];
            $user_agent     = $data[$key]['_source']['user_agent'];
            $timestamp      = $data[$key]['_source']['@timestamp'];
            $sort           = $data[$key]['sort'][0];
            $editday        = explode("T", $timestamp);
            $day            = $editday[0];
            $edtime         = explode(".", $editday[1]);
            $time           = $edtime[0];
            $num            = $edtime[1];

            array_push($apiData, array(
                'indexes'        => $index,
                'type'           => $type,
                'api_id'         => $api_id,
                'score'          => $score,
                'server_name'    => $server_name,
                'remote'         => $remote,
                'route'          => $route,
                'route_path'     => $route_path,
                'request_method' => $request_method,
                'user'           => $user,
                'http_args'      => $http_args,
                'log_id'         => $log_id,
                'status'         => $status,
                'size'           => $size,
                'referer'        => $referer,
                'user_agent'     => $user_agent,
                'timestamp'      => $timestamp,
                'day'            => $day,
                'time'           => $time,
                'num'            => $num,
                'sort'           => $sort
            ));
        }
        $dataBox = array_chunk($apiData, 1000, false);
        if (!empty($dataBox)) {
            foreach ($dataBox as $value) {
                $job = new saveapi($value);
                dispatch($job);
            }
        }
        unset($apiData);
    }
}
