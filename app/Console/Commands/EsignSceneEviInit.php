<?php

namespace App\Console\Commands;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 定义行业类型 法律服务

        // 定义业务凭证名称
    }
}
