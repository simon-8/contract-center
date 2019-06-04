<?php
/**
 * Note: 用户数据
 * User: Liu
 * Date: 2018/12/18
 * Time: 21:08
 */
namespace App\Redis;

use App\Models\User as Model;
use Illuminate\Support\Facades\Redis;

class UserRedis
{
    /**
     * 生成key
     * @param $data
     * @return string
     */
    protected static function makeKeys($data)
    {
        $key = "user:{$data['id']}";
        return $key;
    }

    /**
     * 创建
     * @param $data
     */
    public static function create($data)
    {
        $key = self::makeKeys($data);
        $keysArr = ['id', 'username', 'nickname', 'money', 'session_key'];
        foreach ($data as $k => $v) {
            if (in_array($k, $keysArr)) {
                Redis::hmset($key, [$k => $v]);
            }
        }
    }

    /**
     * 更新
     * @param $data
     */
    public static function update($data)
    {
        $key = self::makeKeys($data);
        $keysArr = ['id', 'username', 'nickname', 'money', 'session_key'];
        foreach ($data as $k => $v) {
            if (in_array($k, $keysArr)) {
                Redis::hmset($key, [$k => $v]);
            }
        }
    }

    /**
     * 删除
     * @param $data
     */
    public static function delete($data)
    {
        $key = self::makeKeys($data);
        Redis::del($key);
    }

    /**
     * 删除所有
     */
    public static function clearAll()
    {
        $keys = Redis::keys("user:*");
        foreach ($keys as $key) {
            Redis::del($key);
        }
    }

    public static function find($id)
    {
        $key = self::makeKeys(['id' => $id]);
        return Redis::hgetall($key);
    }
}