<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractTplRule extends Model
{
    protected $table = 'contract_tpl_rules';

    protected $fillable = [
        'catid',
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
