<?php
namespace App\Repositories;
use App\Models\Lottery;

class LotteryRepository
{
    protected $model;
    protected static $pageSize = 15;

    public function __construct()
    {
        $this->model = new Lottery();
    }

    /**
     * 列表
     * @param null $pagesize
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function lists($pagesize = null)
    {
        return $this->model->paginate($pagesize ? intval($pagesize) : self::$pageSize);
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