<?php
/**
 * Note: 后台管理员
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Manager;

class ManagerRepository
{
    protected $model;
    protected static $pageSize = 15;
    public function __construct()
    {
        $this->model = new Manager();
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
     * 密码加密
     * @param $password
     * @return bool|string
     */
    protected function encypt_password($password)
    {
        return password_hash($password , PASSWORD_DEFAULT);
    }

    /**
     * 密码校验
     * @param $input_password
     * @param $password
     * @return bool
     */
    public function compare_password($input_password , $password)
    {
        return password_verify($input_password , $password);
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
        $data['password'] = $this->encypt_password($data['password']);
        return $this->model->create($data);
    }

    /**
     * 更新
     * @param $data
     * @return bool
     */
    public function update($data)
    {
        $data['is_admin'] = isset($data['is_admin']) && $data['is_admin'] ? 1 : 0;
        if(!empty($data['password'])) {
            $data['password'] = $this->encypt_password($data['password']);
        } else {
            unset($data['password']);
        }
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