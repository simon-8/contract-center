<?php
/**
 * Note: 后台管理菜单
 * User: Liu
 * Date: 2018/3/11
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Menu;

class MenuRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Menu();
    }

    /**
     * 获取所有菜单
     * @return array
     */
    public function lists()
    {
        $all = $this->model->orderBy('listorder', 'desc')->get()->toArray();
        $data = [];
        foreach ($all as $k => $v) {
            if($v['pid'] == 0) {
                if($v['prefix']){
                    $v['url'] = routeNoCatch($v['prefix'] . '.' . $v['route']);
                }else{
                    $v['url'] = routeNoCatch($v['route']);
                }
                $data[$v['id']] = $v;
                unset($all[$k]);
            }
        }
        foreach ($all as $k=>$v) {
            $v['url'] = routeNoCatch($v['prefix'] . '.' . $v['route']);
            $data[$v['pid']]['child'][$v['id']] = $v;
        }
        return $data;
    }

    /**
     * 创建
     * @param $data
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        if ($data['pid']) {
            $this->model->where('id', $data['pid'])->increment('items' , 1);
        }
        return $this->model->create($data);
    }

    /**
     * 更新
     * @param $data
     * @return bool
     */
    public function update($data)
    {
        $menu = $this->model->find($data['id']);
        if ($data['pid'] != $menu->pid) {
            $this->model->where('id', $menu->pid)->decrement('items' , 1);
            $this->model->where('id', $data['pid'])->increment('items' , 1);
        }
        return $menu->update($data);
    }

    /**
     * 删除
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $menu = $this->model->find($id);
        $child = $this->model->where('pid', $menu->id)->get()->toArray();
        if (count($child)) {
            return false;
        }
        if ($menu->pid) {
            $this->model->where('id', $menu->pid)->decrement('items' , 1);
        }
        return $this->model->destroy($id);
    }
}