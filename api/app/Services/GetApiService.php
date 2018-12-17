<?php

namespace App\Services;
ini_set('memory_limit', '-1');
use App\Repositories\ApiRepository;
use App\Jobs\Saveapi;
use Curl;

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

    public function getApi($dateStart, $dateEnd, $num)
    {
        $curl = new Curl\Curl();
        $url  = 'http://train.rd6/?start='.$dateStart.'&end='.$dateEnd.'&from='.$num;
        $curl->get($url);
        $data = json_decode($curl->response, true);
        curl_close($curl->curl);
        return $data;
    }

    public function insertAllData($dateStart, $dateEnd)
    {
        $i = 0;
        $countData = 10000;
        do{
            $fromNumber = $i * $countData;
            $data = $this->getApi($dateStart, $dateEnd, $fromNumber);
            $this->createData($data['hits']['hits']);
            $i++;
        } while ( count($data['hits']['hits']) == $countData );
    }

    public function createData($data)
    {
        $apiData = array();
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
