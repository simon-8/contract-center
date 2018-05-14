<?php
/**
 * Note: 后台管理菜单资源库
 * User: Liu
 * Date: 2018/3/18
 * Time: 19:00
 */
namespace App\Repositories;
use App\Models\Menu;

class MenuRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Menu());
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
            if ($v['pid'] == 0) {
                if ($v['route']) {
                    $v['url'] = route($v['route']);
                } else {
                    $v['url'] = $v['link'];
                }
                $data[$v['id']] = $v;
                unset($all[$k]);
            }
        }
        foreach ($all as $k => $v) {
            if ($v['route']) {
                $v['url'] = route($v['route']);
            } else {
                $v['url'] = $v['link'];
            }
            $data[$v['pid']]['child'][$v['id']] = $v;
        }
        return $data;
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
        return $this->model->destroy($id);
    }

    /**
     * 获取顶级菜单
     * @return \Illuminate\Support\Collection
     */
    public function getTopMenus()
    {
        return $this->model->where('pid', 0)->get();
    }
}