<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContractFile
 *
 * @property int $id
 * @property int $userid 用户ID
 * @property int $contract_id 合同ID
 * @property string $linkurl 材料链接
 * @property string $filetype 文件类型
 * @property int $filesize 文件大小
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile ofContractId($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile whereFilesize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile whereFiletype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile whereLinkurl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFile whereUserid($value)
 * @mixin \Eloquent
 */
class ContractFile extends Model
{
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
