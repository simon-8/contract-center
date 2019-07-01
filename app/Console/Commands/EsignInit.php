<?php

namespace App\Console\Commands;

//use App\Services\EsignService;
use App\Services\EsignService;
use Illuminate\Console\Command;

class EsignInit extends Command
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
    protected $description = '创建e签名';

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
    //protected function saveEnv($data)
    //{
    //    $envData = \File::get(base_path('.env'));
    //    $envData = explode("\r\n", $envData);
    //    foreach ($envData as $key => $env) {
    //        $name = substr($env, 0, strpos($env, '='));
    //        switch ($name) {
    //            case 'ESIGN_BUSID':
    //                $envData[$key] = $name .'='. $data['ESIGN_BUSID'];
    //                break;
    //            case 'ESIGN_SCENEID':
    //                $envData[$key] = $name .'='. $data['ESIGN_SCENEID'];
    //                break;
    //            default:
    //                //$envData[$key] = $name .'='. $val;
    //                break;
    //        }
    //    }
    //    $envData = implode("\r\n", $envData);
    //    $saveResult = \File::put(base_path('.env'), $envData);
    //    return $saveResult;
    //}

    /**
     *
     * @param EsignService $esignService
     * @return bool
     */
    public function handle(EsignService $esignService)
    {
        $eSignObject = $esignService::$eSign;
        try {
            $resCode = $eSignObject->init();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }

        if ($resCode) {
            $this->error('初始化失败');
            return false;
        }
        $this->line("初始化成功");
    }
}
