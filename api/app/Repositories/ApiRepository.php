<?php

namespace App\Repositories;


use App\Api;

class ApiRepository
{
    /** @var api 注入的api model */
    protected $api;

    /**
     * UserRepository constructor.
     * @param JohnApi $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function apiInsert($data)
    {
        Api::insert($data);
    }

    public function apiSelect($data)
    {
        $result = Api::whereIn('api_id', $data)->pluck('api_id')->toArray();
        return $result;
    }
}
