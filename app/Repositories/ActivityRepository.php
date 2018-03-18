<?php
/**
 * Note: 活动管理
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Activity;

class ActivityRepository
{
    protected $model;
    protected static $pageSize = 15;
    public function __construct()
    {
        $this->model = new Activity();
    }

    /**
     * 列表
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function lists()
    {
        return $this->model->paginate(self::$pageSize);
    }

    /**
     * @param $id
     * @return mixed|static
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * 根据username查找用户
     * @param $username
     * @return mixed
     */
    public function findByUsername($username)
    {
        return $this->model->where('username' , $username)->first();
    }

    /**
     * 创建
     * @param $data
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * 更新
     * @param $data
     * @return bool
     */
    public function update($data)
    {
        $item = $this->model->find($data['id']);
        return $item->update($data);
    }

    /**
     * 删除
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}