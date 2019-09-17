<?php

namespace App\Console\Commands;

use App\Services\ContractService;
use App\Services\EsignService;
use Illuminate\Console\Command;
use tech\constants\OrganizeTemplateType;
use tech\constants\SealColor;

class Debug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @throws \Exception
     */
    public function handle()
    {
        $contractService = new ContractService();
        $signData = $contractService->makeSimpleSignData('刘文静');
        $imageData = "data:image/png;base64,". $signData;
        dd($imageData);
        //$esignService = new EsignService();
        //$res = $esignService->addOrganizeTemplateSeal(
        //    '7075EE6532884300BA06036F2AAC00C2',
        //    OrganizeTemplateType::RECT,
        //    SealColor::BLACK,
        //    '杭州道易企业管理咨询有限公司'
        //);
        //dd($res);
    }
}
