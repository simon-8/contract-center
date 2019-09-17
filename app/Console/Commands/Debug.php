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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$contractService = new ContractService();
        //$signData = $contractService->makeSimpleSignData('杭州道易企业管理咨询有限公司');
        //$imageData = "data:image/png;base64,". $signData;
        //dd($imageData);
        $esignService = new EsignService();
        $esignService->addOrganizeTemplateSeal(
            '0EA9F7D90B594F39B8DE8121BA754517',
            OrganizeTemplateType::RECT,
            SealColor::BLACK,
            '杭州道易企业管理咨询有限公司'
        );
    }
}
