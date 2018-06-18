<?php
/**
 * Note: 仓库基类
 * User: Liu
 * Date: 2018/6/4
 */
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository1
{
    protected $model;
    public static $pageSize = 15;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * 查询所有
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * 列表查询
     * @param $where
     * @param $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function lists($where = [], $page = true)
    {
        $query = $this->model;
        if ($where) $query = $query->where($where);
        return $page ? $query->paginate(self::$pageSize) : $query->get();
    }

    /**
     * 根据主键ID查找
     * @param $id
     * @return mixed|static
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $where
     * @return mixed
     */
    public function first($where)
    {
        return $this->model->where($where)->first();
    }

    /**
     * 根据字段查找
     * @param $field
     * @param $value
     * @return Model|null|object|static
     */
    public function findBy($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    /**
     * 新增
     * @param array $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * 更新
     * @param array $data
     * @return mixed
     */
    public function update($data)
    {
        $item = $this->find($data[$this->model->getKeyName()]);
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

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}