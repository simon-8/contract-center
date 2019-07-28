<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class ContractFile extends Model
{
    use ModelTrait;

    protected $table = 'contract_file';

    protected $fillable = [
        'userid',
        'contract_id',
        //'folder_id',
        //'name',
        'linkurl',
        'filetype',
        'filesize',
    ];

    /**
     * @param $value
     * @return string
     */
    //public function getLinkurlAttribute($value)
    //{
    //    return $value ? imgurl($value) : '';
    //}

    /**
     * 用户id
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfUserid($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('userid', $data);
    }

    /**
     * 合同ID
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfContractId($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('contract_id', $data);
    }

    /**
     * 文件夹ID
     * @param $query
     * @param int $data
     * @return mixed
     */
    //public function scopeOfFolderId($query, $data = 0)
    //{
    //    if (!$data) return $query;
    //    return $query->where('folder_id', $data);
    //}
}
