<?php
/**
 * Note: model基类
 * User: Liu
 * Date: 2019/6/27
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{

    /**
     * 状态
     * @param $query
     * @param null $data
     * @return mixed
     */
    public function scopeOfStatus($query, $data = '')
    {
        if ($data === '') return $query;
        if (is_array($data)) {
            return $query->whereIn('status', $data);
        } else {
            return $query->where('status', $data);
        }
    }

    /**
     * 分类ID
     * @param $query
     * @param int $data
     * @return mixed
     */
    public function scopeOfCatid($query, $data = '')
    {
        if ($data === '') return $query;
        if (is_array($data)) {
            return $query->whereIn('catid', $data);
        } else {
            return $query->where('catid', $data);
        }
    }

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
     * 添加时间
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
}