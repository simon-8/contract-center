<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/11
 * Time: 18:01
 */
namespace App\Models;
use App\Services\ModelService;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use ModelService;
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'pid',
        'name',
        'route',
        'link',
        'icon',
        'listorder',
        'items',
    ];

    public function parent()
    {
        return $this->hasOne('App\Models\Menu', 'id', 'pid');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'pid', 'id');
    }

    /**
     * @return array
     */
    public function getMenus()
    {
        $all = $this->orderBy('listorder', 'desc')->get()->toArray();
        $data = [];
        foreach ($all as $k => $v) {
            if ($v['pid'] == 0) {
                if ($v['route']) {
                    $v['url'] = routeNoCatch($v['route']);
                } else {
                    $v['url'] = $v['link'];
                }
                $data[$v['id']] = $v;
                unset($all[$k]);
            }
        }
        foreach ($all as $k => $v) {
            if ($v['route']) {
                $v['url'] = routeNoCatch($v['route']);
            } else {
                $v['url'] = $v['link'];
            }
            $data[$v['pid']]['child'][$v['id']] = $v;
        }
        return $data;
    }

}