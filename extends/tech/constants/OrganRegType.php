<?php
/**
 * User: wanglf
 * Date: 2016/12/14
 */

namespace tech\constants;


class OrganRegType
{

    // 组织机构代码号
    const NORMAL = '0';

    // 三证合一营业执照
    const MERGE = '1';

    // 工商注册号
    const REGCODE = '2';

    const OTHER = '23';

    //注册证件类型
    public static function getArray()
    {
        return array(
            self::NORMAL,
            self::MERGE,
            self::REGCODE
        );
    }
}

