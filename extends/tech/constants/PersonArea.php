<?php
/**
 * User: wanglf
 * Date: 2016/12/14
 */
namespace tech\constants;


class PersonArea
{
    /// 大陆
    const MAINLAND = '0';

    /// 香港
    const HONGKONG = '1';

    /// 澳门
    const MACAO = '2';

    /// 台湾
    const TAIWAN = '3';

    /// 外籍
    const FOREIGN = '4';

    const OTHER = '23';

    /// 用户地区
    public static function  getArray()
    {
        return array(
            self::MAINLAND,
            self::HONGKONG,
            self::MACAO,
            self::TAIWAN,
            self::FOREIGN,
            self::OTHER
        );
    }

}