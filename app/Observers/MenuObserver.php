<?php
/**
 * Note: Menu模型观察者
 * User: Liu
 * Date: 2018/3/12
 * Time: 22:53
 */
namespace App\Observers;
use App\Models\Menu;

class MenuObserver
{
    /**
     * 增加计数
     * @param Menu $menu
     */
    public function created(Menu $menu)
    {
        if ($menu['pid']) {
            $menu->where('id', $menu['pid'])->increment('items' , 1);
        }
    }

    /**
     * 更新计数
     * @param Menu $menu
     */
    public function updated(Menu $menu)
    {
        if ($menu['pid'] != $menu->getOriginal('pid')) {
            $menu->where('id', $menu->getOriginal('pid'))->decrement('items' , 1);
            $menu->where('id', $menu['pid'])->increment('items' , 1);
        }
    }

    /**
     * 清除计数
     * @param Menu $menu
     */
    public function deleted(Menu $menu)
    {
        if ($menu['pid']) {
            $menu->where('id', $menu['pid'])->decrement('items' , 1);
        }
    }
}