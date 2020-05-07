<?php

namespace App\Console\Commands;

use App\Models\ContractCategory;
use App\Services\EsignSceneEviService;
use Illuminate\Console\Command;

class EsignSceneEviInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'esign:scene-evi-init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esign 场景式存证 初始化';

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
     * @param EsignSceneEviService $sceneEviService
     * @throws \Exception
     */
    public function handle(EsignSceneEviService $sceneEviService)
    {
        // 定义行业类型 法律服务
        $sceneEviService->createBusiness();

        // 为已有分类创建数据字典
        $categorys = ContractCategory::all();
        foreach ($categorys as $category) {
            $sceneEviService->categoryCreated($category);
        }
    }
}
