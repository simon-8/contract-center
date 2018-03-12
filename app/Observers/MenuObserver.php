<?php
/**
 * Note: *
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
     * @return bool
     */
    public function created(Menu $menu)
    {
        if ($menu['pid']) {
            $menu->where('id', $menu['pid'])->increment('items' , 1);
        }
        return true;
    }

    //public function updating(Menu $menu)
    //{
    //
    //}

    /**
     * 更新计数
     * @param Menu $menu
     * @return bool
     */
    public function updated(Menu $menu)
    {
        if ($menu['pid'] != $menu->getOriginal('pid')) {
            $menu->where('id', $menu->getOriginal('pid'))->decrement('items' , 1);
            $menu->where('id', $menu['pid'])->increment('items' , 1);
        }
        return true;
    }

    /**
     * 清除计数
     * @param Menu $menu
     * @return bool
     */
    public function deleted(Menu $menu)
    {
        if ($menu['pid']) {
            $menu->where('id', $menu['pid'])->decrement('items' , 1);
        }
        return true;
    }
}