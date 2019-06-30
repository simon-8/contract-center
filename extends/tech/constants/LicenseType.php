<?php
/**
 * User: Administrator
 * Date: 2016/12/20
 */

namespace tech\constants;


class LicenseType
{
    /**
     * 企业组织机构代码
     */
    const ORGCODE = '0';
    /**
     * 企业统一信用代码
     */
    const CREDITCODE = '1';
    /**
     * 企业工商注册号
     */
    const REGCODE = '2';
    /**
     * 居民身份证号
     */
    const NORMALIDNO = '51';
    /**
     * 自定义类型
     */
    const SELFDEFINED = '101';

    /**
     * 身份认证类型
     * @return array
     */
    public static function getArray()
    {
        return array(self::ORGCODE, self::CREDITCODE, self::REGCODE, self::NORMALIDNO);
    }
}