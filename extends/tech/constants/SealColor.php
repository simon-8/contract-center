<?php
/**
 * User: wanglf
 * Date: 2016/12/14
 */

namespace tech\constants;


class SealColor
{
    const RED = 'red';
    const BLUE = 'blue';
    const BLACK = 'black';

    /**
     * 印章颜色值：red-红色，blue-蓝色，black-黑色
     * @return array
     */
    public static function getArray()
    {
        return array(
            self::RED,
            self::BLUE,
            self::BLACK
        );
    }
}