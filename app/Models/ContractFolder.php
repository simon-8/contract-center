<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContractFolder
 *
 * @property int $id
 * @property string $name 文件夹名
 * @property string $thumb 缩略图
 * @property int $userid 用户ID
 * @property int $contract_id 合同ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractFolder whereUserid($value)
 * @mixin \Eloquent
 */
class ContractFolder extends Model
{
    protected $table = 'contract_folder';

    protected $fillable = [
        'name',
        'thumb',
        'userid',
        'contract_id',
    ];

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
}
