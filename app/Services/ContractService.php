<?php
/**
 * Note: contract service
 * User: Liu
 * Date: 2019/6/24
 */

namespace App\Services;

use App\Models\Contract;
use Illuminate\Support\Facades\Storage;
use PDF;

class ContractService
{
    //protected $pdfSourceRoot; // pdf原始目录
    //protected $pdfOutputRoot; // pdf输出目录

    //public function __construct()
    //{
    //    $this->pdfSourceRoot = 'pdf/source';
    //    $this->pdfOutputRoot = 'pdf/output';
    //}

    /**
     * 生成存储路径
     * @param $id
     * @param bool $output  为true时选择output目录
     * @return string
     */
    public function makeStorePath($id, $output = false)
    {
        if ($output) {
            $dir = 'pdf/output';
        } else {
            $dir = 'pdf/source';
        }
        return $dir. "/{$id}.pdf";
    }

    /**
     * 生成pdf文档
     * @param Contract $contract
     * @param bool $output
     * @return \Barryvdh\Snappy\PdfWrapper
     */
    public function makePdf(Contract $contract, $output = false)
    {
        $content = $contract->content->getAttribute('content');
        unset($contract->content);
        $contract->content = $content;
        $pdf = PDF::loadView('api.contract.show', compact('contract'));
        $storePath = $this->makeStorePath($contract->id, $output);
        $storePath = Storage::disk('uploads')->path($storePath);
        return $pdf->save($storePath, true);
    }
}
