<?php
/**
 * Note: 奖品管理
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Gift;

class GiftRepository
{
    protected $model;
    protected static $pageSize = 15;
    public function __construct()
    {
        $this->model = new Gift();
    }

    /**
     * 列表
     * @param null $aid
     * @param null $pagesize
     * @return mixed
     */
    public function lists($aid = null, $pagesize = null)
    {
        if (!empty($aid)) {
            return $this->model->where('aid', $aid)->paginate($pagesize ? intval($pagesize) : self::$pageSize);
        } else {
            return $this->model->paginate($pagesize ? intval($pagesize) : self::$pageSize);
        }
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