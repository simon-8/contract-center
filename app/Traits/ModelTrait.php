<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/20
 * Time: 1:06
 */
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ModelTrait
{
    /**
     * ID
     * @param Builder $query
     * @param int $data
     * @return Builder
     */
    public function scopeOfId(Builder $query, $data = 0)
    {
        if (!$data) return $query;
        if (is_array($data)) {
            return $query->whereIn('id', $data);
        } else {
            return $query->where('id', $data);
        }
    }

    /**
     * 状态
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfStatus(Builder $query, $data = '')
    {
        if (!is_numeric($data)) return $query;
        if (is_array($data)) {
            return $query->whereIn('status', $data);
        } else {
            return $query->where('status', $data);
        }
    }

    /**
     * 分类ID
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfCatid(Builder $query, $data = '')
    {
        if (!is_numeric($data)) return $query;
        if (is_array($data)) {
            return $query->whereIn('catid', $data);
        } else {
            return $query->where('catid', $data);
        }
    }

    /**
     * 用户id
     * @param Builder $query
     * @param int $data
     * @return Builder
     */
    public function scopeOfUserid(Builder $query, $data = 0)
    {
        if (!$data) return $query;
        if (is_array($data)) {
            return $query->whereIn('userid', $data);
        } else {
            return $query->where('userid', $data);
        }

    }

    /**
     * 添加时间
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfCreatedAt(Builder $query, $data = '')
    {
        if (empty($data))  return $query;

        list($start, $end) = explode(' - ', $data);
        $end = date('Y-m-d', strtotime($end) + 86400);
        return $query->where("created_at", '>=', $start)->where('created_at', '<', $end);
    }

    /**
     * 更新时间
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfUpdatedAt(Builder $query, $data = '')
    {
        if (empty($data))  return $query;

        list($start, $end) = explode(' - ', $data);
        $end = date('Y-m-d', strtotime($end) + 86400);
        return $query->where("updated_at", '>=', $start)->where('updated_at', '<', $end);
    }
}
