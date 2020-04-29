<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/4/29
 * Time: 22:33
 */
namespace App\Caches;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingCache
{
    const CACHE_TAG = 'setting';

    /**
     * @param $item
     * @return bool|mixed|string
     */
    private static function handleData($item)
    {
        $setting = Setting::whereItem($item)->first();
        return $setting ? $setting->value : false;
    }

    /**
     * @param $item
     * @return mixed
     */
    private static function makeKey($item)
    {
        return $item;
    }

    /**
     * @param Setting $setting
     * @return bool
     */
    public static function set(Setting $setting)
    {
        return Cache::tags(self::CACHE_TAG)->put(
            self::makeKey($setting->item),
            $setting->value
        );
    }


    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        $instance = new self();
        return Cache::tags(self::CACHE_TAG)->rememberForever(
            $key,
            function() use ($instance, $key)  {
                return $instance->handleData($key);
            }
        );
    }

    /**
     * @param $key
     * @return bool
     */
    public static function del($key)
    {
        return Cache::tags(self::CACHE_TAG)->forget(
            self::makeKey($key)
        );
    }

    /**
     * 重置所有缓存
     */
    public static function reset()
    {
        Cache::tags(self::CACHE_TAG)->flush();
        $configs = Setting::get(['item', 'value']);
        foreach ($configs as $config) {
            self::set($config);
        }
    }
}
