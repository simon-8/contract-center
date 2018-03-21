<?php
/**
 * Note: 用户管理
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\User;

class UserRepository
{
    protected $model;
    protected static $pageSize = 15;

    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * 列表
     * @param null $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function lists($keyword = null)
    {
        if ($keyword) {
            $field = is_numeric($keyword) ? 'mobile' : 'truename';
            return $this->model->where($field, 'like', '%'.$keyword.'%')->paginate(self::$pageSize);
        } else {
            return $this->model->paginate(self::$pageSize);
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
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function findByUsername($username)
    {
        return $this->model->where('username' , $username)->first();
    }

    /**
     * 根据openid查找用户
     * @param $openid
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function findByOpenID($openid)
    {
        return $this->model->where('openid' , $openid)->first();
    }

    /**
     * 根据mobile查找用户
     * @param $mobile
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function findByMobile($mobile)
    {
        return $this->model->where('mobile' , $mobile)->first();
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
     * @param $data
     * @return mixed
     */
    public function updateOrCreate($data)
    {
        return $this->model->updateOrCreate([
            'openid' => $data['openid']
        ], $data);
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