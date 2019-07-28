<?php
/**
 * Note: 权限
 * User: Liu
 * Date: 2018/11/20
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    use ModelTrait;

    public $table = 'role_access';

    public $timestamps = false;

    public $fillable = [
        'name',
        'route'
    ];

    /**
     *
     * @return array
     */
    public function accessLists()
    {
        $accessLists = $this->all()->toArray();
        $data = [];
        foreach ($accessLists as $k => $access) {
            if ($access['route'] === '*') {
                $data['god']['id'] = $access['id'];
                $data['god']['name'] = $access['name'];
                continue;
            }
            if (\Str::contains($access['route'], '*')) {
                $route = str_replace('admin.', '', $access['route']);
                $prefix = substr($route, 0, strpos($route, '.')+1);
                $data[$prefix]['id'] = $access['id'];
                $data[$prefix]['name'] = $access['name'];
                unset($accessLists[$k]);
            }
        }
        foreach ($data as $prefix => $name) {
            foreach ($accessLists as $access) {
                if ($access['route'] === '*' && $prefix === 'god') {
                    $data[$prefix]['child'][$access['id']] = $access;
                    continue;
                }
                $route = str_replace('admin.', '', $access['route']);
                if (\Str::startsWith($route, $prefix)) {
                    $data[$prefix]['child'][$access['id']] = $access;
                }
            }
        }
        return $data;
    }

    /**
     * 移除无用子元素
     * 前台传递时可能将父权限+子权限一起传递过来, 需要移除
     * @param $data
     * @return array
     */
    public function makeAccess($data)
    {
        $parents = $childs = [];
        $accessLists = $this->all();
        foreach ($accessLists as $k => $access) {
            if ($access['route'] === '*') {
                $parents['god'] = $access['id'];
                continue;
            }
            // 拆分路由前缀
            $prefix = substr($access['route'], 0, strpos($access['route'], '.'));
            if (strpos($access['route'], '*') !== false) {
                $parents[$prefix] = $access['id'];
            } else {
                if ($prefix) {
                    $parentid = $parents[$prefix] ?? $access['id'];
                    $childs[$parentid][] = $access['id'];
                } else {
                    $childs[$access['id']][] = $access['id'];
                }
            }
        }
        // 超级权限
        if (in_array($parents['god'], $data)) {
            $data = [1];
            return $data;
        }

        // 查找无用子元素
        $myParents = array_intersect(array_values($parents), $data);
        foreach ($myParents as $parentRoute => $parentId) {
            if (!empty($childs[$parentId])) {
                // 移除已有父元素的子元素
                $data = array_diff($data, array_values($childs[$parentId]));
            }
        }
        return $data;
    }
}
