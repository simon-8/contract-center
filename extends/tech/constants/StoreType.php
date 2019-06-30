<?php
/**
 * User: Administrator
 * Date: 2017/2/28
 */

namespace tech\constants;


class StoreType
{
    /**
     * e签宝
     */
    const ESIGN_STORE = '0';
    /**
     * 公证处
     */
    const NOTAY_STORE = '1';


    /**
     * 身份认证类型
     * @return array
     */
    public static function getArray()
    {
        return array(self::ESIGN_STORE, self::NOTAY_STORE);
    }
}