<?php
/**
 * User: wanglf
 * Date: 2016/12/14
 */

namespace tech\constants;


class EventType
{

    //文本类型
    const EVENT_TYPE_FILE = 'file';

    ///文件类型
    const EVENT_TYPE_TEXT = 'text';


    // 事件描述类型
    public static function  getArray()
    {
        return array(self::EVENT_TYPE_FILE, self::EVENT_TYPE_TEXT);
    }

}

