<?php
/**
 * Note: 日志资源库
 * User: Liu
 * Date: 2018/7/28
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\AdminLogs as Model;

class AdminLogsRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Model());
    }

    public function lists($where = [], $page = true)
    {
        $query = $this->model;
        if ($where) $query = $query->where($where);
        $query = $query->orderBy('id', 'DESC');
        return $page ? $query->paginate(self::$pageSize) : $query->get();
    }
}