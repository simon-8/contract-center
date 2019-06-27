<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContractTplFill
 *
 * @property int $id
 * @property int $catid 分类
 * @property string $formname 表单名称
 * @property string $content 内容
 * @property int $listorder 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill ofCatid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill ofContent($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill whereFormname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill whereListorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContractTplFill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContractTplFill extends Base
{
    protected $table = 'contract_tpl_fills';

    protected $fillable = [
        'catid',
        'formname',
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
