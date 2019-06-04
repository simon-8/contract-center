<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractTemplate extends Model
{
    protected $table = 'contract_template';

    protected $fillable = [
        'catid',
        'typeid',
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
     * @param int $data
     * @return mixed
     */
    public function scopeOfTypeid($query, $data = 0)
    {
        if (!$data) return $query;
        return $query->where('typeid', $data);
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
     * @param bool $all
     * @return array|mixed
     */
    public function getCats($all = false)
    {
        $cats = [
            0 => '两方合同',
            1 => '三方合同',
        ];
        if ($all) {
            return $cats;
        }
        return $cats[$this->catid];
    }

    /**
     * @param bool $all
     * @return array|mixed
     */
    public function getTypes($all = false)
    {
        $types = [
            0 => '通用条款',
            1 => '合同条款',
        ];
        if ($all) {
            return $types;
        }
        return $types[$this->typeid];
    }

}