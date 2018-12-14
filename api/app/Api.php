<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    /**
    * 與模型關聯的資料表。
    *
    * @var string
    */
    protected $table = 'api';

    // primaryKey
    protected $primaryKey = 'ID';

    // 關閉 timestamps
    public $timestamps = false;

}
