<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Api extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api', function (Blueprint $table) {
            $table->string('index', 20);
            $table->string('type', 10);
            $table->binary('id')->unique();
            $table->string('score', 10)->nullable($value = true);
            $table->string('server_name', 25);
            $table->string('remote', 50);
            $table->string('route', 10);
            $table->string('route_path', 30);
            $table->string('request_method', 5);
            $table->string('user', 10);
            $table->string('http_args', 500);
            $table->string('log_id', 30);
            $table->string('status', 10);
            $table->string('size', 10);
            $table->string('referer', 5);
            $table->string('user_agent', 15);
            $table->string('timestamp', 50);
            $table->date('day');
            $table->time('time');
            $table->string('num', 20);
            $table->string('sort', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api');
    }
}
