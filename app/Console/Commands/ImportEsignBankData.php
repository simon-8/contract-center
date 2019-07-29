<?php
/**
 * Note: 导入
 * User: Liu
 * Date: 2019/7/29
 * Time: 22:40
 */
namespace App\Console\Commands;

//use App\Services\EsignService;
use App\Imports\EsignBankDataImport;
use App\Models\EsignBank;
use App\Models\EsignBankArea;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportEsignBankData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:esign-bank-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入E签名实名认证银行省市列表';

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
     * @return bool
     */
    public function handle()
    {
        ini_set('memory_limit','512M');

        EsignBankArea::truncate();
        EsignBank::truncate();
        $this->line('EsignBankArea EsignBank 表已清空');

        $areaPath = base_path('extends/tech/excel/area.xlsx');
        $areaData = Excel::toArray(new EsignBankDataImport(), $areaPath);
        foreach ($areaData[0] as $k => $v) {
            if ($k == 0) {
                continue;
            }
            EsignBankArea::create([
                'province' => $v[0] ?: '',
                'city'  => $v[1] ?: '',
            ]);
        }

        $bankPath = base_path('extends/tech/excel/bank.csv');
        $bankData = Excel::toArray(new EsignBankDataImport(), $bankPath);
        foreach ($bankData[0] as $k => $v) {
            EsignBank::create([
                'bank_code' => $v[0] ?: '',
                'bank_name' => $v[3] ?: '',
                'sub_name' => $v[10] ?: '',
                'province' => $v[2] ?: '',
                'city' => $v[1] ?: '',
            ]);
        }

        $this->line("初始化成功");
    }
}
