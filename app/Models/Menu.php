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

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $pid 父ID
 * @property string $name 菜单名称
 * @property string $route 路由名称
 * @property string $link 目标链接
 * @property string $icon 图标名称
 * @property int $listorder 排序
 * @property int $items 子分类数量
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Menu[] $children
 * @property-read \App\Models\Menu $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereListorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereRoute($value)
 * @mixin \Eloquent
 */
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