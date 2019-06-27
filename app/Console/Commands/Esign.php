<?php

namespace App\Console\Commands;

use App\Services\EsignService;
use Illuminate\Console\Command;

class Esign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'esign:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建e签名初始数据字典';

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
     * 保存配置文件
     * @param $data
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function saveEnv($data)
    {
        $envData = \File::get(base_path('.env'));
        $envData = explode("\r\n", $envData);
        foreach ($envData as $key => $env) {
            $name = substr($env, 0, strpos($env, '='));
            switch ($name) {
                case 'ESIGN_BUSID':
                    $envData[$key] = $name .'='. $data['ESIGN_BUSID'];
                    break;
                case 'ESIGN_SCENEID':
                    $envData[$key] = $name .'='. $data['ESIGN_SCENEID'];
                    break;
                default:
                    //$envData[$key] = $name .'='. $val;
                    break;
            }
        }
        $envData = implode("\r\n", $envData);
        $saveResult = \File::put(base_path('.env'), $envData);
        return $saveResult;
    }

    public function handle(EsignService $esignService)
    {
        $response = $esignService->busAdd([
            '房屋租赁行业'
        ]);
        if (!$response['success']) {
            $this->error("新增行业失败");
            return;
        }
        $result = $response['result'];

        //if (!$saveResult) {
        //    $this->error("配置生成失败");
        //    return;
        //}
        //$this->info("配置生成成功");
    }
}
