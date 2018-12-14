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

    public function apiInsert($_array)
    {
        Api::insert($_array);
    }

    public function apiSelect($_array)
    {
        $result = Api::whereIn('api_id', $_array)->pluck('api_id')->toArray();
        return $result;
    }
}
