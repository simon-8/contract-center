<?php
/**
 * User: Administrator
 * Date: 2016/12/29
 */

namespace tech\constants;


class SignType
{
    const SINGLE = 'Single'; //单页签章
    const MULTI = 'Multi'; //多页签章
    const EDGES = 'Edges'; //骑缝签章
    const KEYWORD = 'Key'; //关键字签章

    //签章类型
    public static function  getArray()
    {
        return array(self::SINGLE, self::MULTI, self::EDGES, self::KEYWORD);
    }
}