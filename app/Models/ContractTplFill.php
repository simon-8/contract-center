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
class ContractTplFill extends Model
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
     * @param int $data
     * @return mixed
     */
    public function scopeOfCatid($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('catid', $data);
    }

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

    /**
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfCreatedAt($query, $data = '')
    {
        if (empty($data)) {
            return $query;
        }
        list($start, $end) = explode(' - ', $data);
        $end = date('Y-m-d', strtotime($end) + 86400);
        return $query->where("created_at", '>=', $start)->where('created_at', '<', $end);
    }

    /**
     * 获取类型数组
     * @return array
     */
    public function getTypes()
    {
        $types = [
            0 => '通用条款',
            1 => '合同条款',
        ];
        return $types;
    }

    /**
     * 获取分类名
     * @param $typeid
     * @return mixed|string
     */
    public function getTypeText($typeid = null)
    {
        if ($typeid === null) $typeid = $this->typeid;
        return $this->getTypes()[$typeid] ?? 'not found';
    }
}
