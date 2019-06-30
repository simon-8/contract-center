<?php
/**
 * User: wanglf
 * Date: 2016/12/14
 */

namespace tech\constants;


class UserType
{
    // 代理人注册
    const USER_DEFAULT = '0';

    // 代理人注册
    const USER_AGENT = '1';

    /// 法人注册
    const USER_LEGAL = '2';


    // 注册用户类型
    public static function  getArray()
    {
        return array(self::USER_AGENT, self::USER_LEGAL, self::USER_DEFAULT);
    }

}

