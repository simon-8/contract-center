<?php
/**
 * Note: contract service
 * User: Liu
 * Date: 2019/6/24
 */

namespace App\Services;

use App\Models\Contract;
use PDF;

class ContractService
{
    protected $pdfSourceRoot; // pdf原始目录
    protected $pdfOutputRoot; // pdf输出目录

    public function __construct()
    {
        $basePath = config('filesystems.disks.uploads.root'). '/pdf';
        $this->pdfSourceRoot = $basePath. '/source';
        $this->pdfOutputRoot = $basePath.'/output';
    }

    /**
     * 生成存储路径
     * @param $id
     * @param bool $output
     * @return string
     */
    public function makeStorePath($id, $output = false)
    {
        if ($output) {
            $dir = $this->pdfOutputRoot;
        } else {
            $dir = $this->pdfSourceRoot;
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
        return $pdf->save($storePath, true);
    }
}