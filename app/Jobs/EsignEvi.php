<?php

namespace App\Jobs;

use App\Models\Contract;
use App\Models\EsignEviLink;
use App\Models\EsignEviPoint;
use App\Services\EsignSceneEviService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EsignEvi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contract = null;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function handle(EsignSceneEviService $service)
    {
        /**
         * 1. 创建证据链
         * 2. 创建证据点 (原文基础版认证)
         * 3. 上传文档
         * 4. 关联证据点和证据链
         * 5. 关联证据链和用户
         */
        try {
            $link = EsignEviLink::where('contract_id', $this->contract->id)->first();
            if (!$link) {
                $link = $service->createLink($this->contract);
            }

            if ($link->status === EsignEviLink::STATUS_INIT) {
                $service->createPointBasic($this->contract, $link);
                $link->update(['status' => EsignEviLink::STATUS_POINT_CREATED]);
            }

            if ($link->status === EsignEviLink::STATUS_POINT_CREATED) {
                $point = EsignEviPoint::where('contract_id', $this->contract->id)->first();
                $filePath = Storage::disk('uploads')->path($this->contract->path_pdf);
                $service->uploadFile($point['url'], $filePath);
                $link->update(['status' => EsignEviLink::STATUS_FILE_UPLOAD]);
            }

            if ($link->status === EsignEviLink::STATUS_FILE_UPLOAD) {
                $service->addPointToLink($this->contract);
                $link->update(['status' => EsignEviLink::STATUS_POINT_LINKED]);
            }

            if ($link->status === EsignEviLink::STATUS_POINT_LINKED) {
                $service->addLinkToUser($this->contract);
                $link->update(['status' => EsignEviLink::STATUS_USER_LINKED]);
            }
            info(__METHOD__, ['成功']);
        } catch (\Exception $e) {
            Log::error(__METHOD__, [$e->getMessage()]);
        }

    }
}
