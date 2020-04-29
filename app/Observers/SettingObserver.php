<?php
/**
 * Note: 设置
 *
 * User: Liu
 * Date: 2019/6/21
 * Time: 21:15
 */
namespace App\Observers;

use App\Caches\SettingCache;
use App\Models\Setting;

class SettingObserver
{
    public function created(Setting $data)
    {
        SettingCache::set($data);
    }

    public function updated(Setting $data)
    {
        SettingCache::set($data);
    }
}
