<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
class example extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:Log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test schedule';

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
        // 檔案紀錄在storage/test.log
        $log_file_path = storage_path('test.log');

        // 記錄當時時間
        $log_info = [
            'date'=>date('Y-m-d H:i:s')
        ];

        // 記錄 Json 字串
        $log_info_json = json_encode($log_info) . "\r\n";
        print(gettype($log_info_json));
        // 寫入test.log
        File::append($log_file_path, $log_info_json);
    }
}
