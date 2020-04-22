<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\CompanyStaff;
use App\Models\Contract;
use Illuminate\Console\Command;

class CalcCompanyAttribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:company-attribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计算公司指定属性: 员工数量、合同数量';

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
        $updateData = [];
        // 员工数量
        $companyIds = CompanyStaff::where('status', CompanyStaff::STATUS_SUCCESS)
            //->where('updated_at', '>=', $this->timeStart())
            ->distinct()
            ->get(['company_id'])
            ->pluck('company_id')
            ->all();
        foreach ($companyIds as $companyId) {
            $updateData[$companyId]['staff_count'] = CompanyStaff::whereCompanyId($companyId)
                ->where('status', CompanyStaff::STATUS_SUCCESS)
                ->count();
        }

        // 最近变更过的合同
        $contracts = Contract::where(function ($query) {
            $query->where(function ($query) {
                $query->where('signed_first', 1)->where('companyid_first', '>', 0);
            })->orWhere(function ($query) {
                $query->where('signed_second', 1)->where('companyid_second', '>', 0);
            })->orWhere(function ($query) {
                $query->where('signed_three', 1)->where('companyid_three', '>', 0);
            });
        })
        //->where('updated_at', '>=', $this->timeStart())
        ->get([
            'companyid_first',
            'companyid_second',
            'companyid_three',
            'signed_first',
            'signed_second',
            'signed_three'
        ])
        ->toArray();

        $companyIds = [];
        foreach ($contracts as $contract) {
            if ($contract['signed_first'] && $contract['companyid_first']) {
                $companyIds[] = $contract['companyid_first'];
            }
            if ($contract['signed_second'] && $contract['companyid_second']) {
                $companyIds[] = $contract['companyid_second'];
            }
            if ($contract['signed_three'] && $contract['companyid_three']) {
                $companyIds[] = $contract['companyid_three'];
            }
        }
        // 去重
        $companyIds = array_unique($companyIds);
        foreach ($companyIds as $companyId) {
            // 签章数量(单方面签章)
            $updateData[$companyId]['contract_signed_count'] = Contract::where(function ($query) use ($companyId) {
                $query->where(function ($query) use ($companyId) {
                    $query->where('signed_first', 1)->where('companyid_first', $companyId);
                })->orWhere(function ($query) use ($companyId) {
                    $query->where('signed_second', 1)->where('companyid_second', $companyId);
                })->orWhere(function ($query) use ($companyId) {
                    $query->where('signed_three', 1)->where('companyid_three', $companyId);
                });
            })
            ->where('status', '<', Contract::STATUS_SIGN)
            ->count();

            // 成功数量(双方签章)
            $updateData[$companyId]['contract_success_count'] = Contract::where(function ($query) use ($companyId) {
                $query->where(function ($query) use ($companyId) {
                    $query->where('signed_first', 1)->where('companyid_first', $companyId);
                })->orWhere(function ($query) use ($companyId) {
                    $query->where('signed_second', 1)->where('companyid_second', $companyId);
                })->orWhere(function ($query) use ($companyId) {
                    $query->where('signed_three', 1)->where('companyid_three', $companyId);
                });
            })
            ->where('status', Contract::STATUS_SIGN)
            ->count();
        }

        foreach ($updateData as $companyId => $data) {
            Company::where('id', $companyId)
                ->update($data);
        }
    }

    protected function timeStart()
    {
        return now()->subMinutes(10);
    }
}
