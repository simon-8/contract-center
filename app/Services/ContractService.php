<?php
/**
 * Note: contract service
 * User: Liu
 * Date: 2019/6/24
 */
namespace App\Services;

class ContractService
{
    /**
     * 获取分类
     * @return array
     */
    public static function getCats()
    {
        $cats = [
            0 => '通用',
            1 => '两方',
            2 => '三方',
        ];
        return $cats;
    }

    /**
     * 获取分类名
     * @param $catid
     * @return mixed|string
     */
    public static function getCatText($catid = null)
    {
        if ($catid === null) return '';
        return self::getCats()[$catid] ?? 'not found';
    }
}