<?php
/**
 * User: wanglf
 * Date: 2016/12/14
 */

namespace tech\constants;


class OrganizeTemplateType
{
    const STAR = 'star';
    const OVAL = 'oval';
    const RECT = 'rect';
    const DEDICATED = 'dedicated';
    /**
     * 企业模板
     * star-标准公章，oval-椭圆形印章， rect-条形印章， dedicated-去五角星印章
     * @return array
     */
    public static function getArray()
    {
        return array(self::STAR, self::OVAL, self::RECT, self::DEDICATED);
    }
}