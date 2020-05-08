<?php

namespace App\Console\Commands;

use App\Jobs\StoreEsignEvi;
use App\Models\Contract;
use Illuminate\Console\Command;

class EsignEviStoreQuick extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'esign:evi-store-quick {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '数据存证 - 快速存证';

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
        $contract = Contract::find($this->argument('id'));
        StoreEsignEvi::dispatchNow($contract);
    }
}
