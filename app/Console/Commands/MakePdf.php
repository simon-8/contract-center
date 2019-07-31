<?php

namespace App\Console\Commands;

use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Console\Command;

class MakePdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makepdf {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '为指定合同生成pdf文档';

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
    public function handle(ContractService $contractService)
    {
        $id = $this->argument('id');
        $contractData = Contract::find($id);
        $contractService->makePdf($contractData);
        $this->info('操作成功');
    }
}
