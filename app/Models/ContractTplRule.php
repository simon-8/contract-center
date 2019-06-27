<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContractTplRule
 *
 * @property int $id
 * @property int $catid 分类
 * @property string $content 内容
 * @property int $listorder 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule ofCatid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule ofContent($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule whereListorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContractTplRule extends Base
{
    protected $table = 'contract_tpl_rules';

    protected $fillable = [
        'catid',
        'content',
        'listorder',
    ];

    /**
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfContent($query, $data = '')
    {
        if (empty($data)) return $query;
        return $query->where('content', 'like', "%{$data}%");
    }
}
