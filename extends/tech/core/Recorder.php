<?php
/**
 * User: Administrator
 * Date: 2016/12/8
 */

namespace tech\core;

use tech\core\Util;

class Recorder
{
    private static $data;


    public function __construct()
    {
        //-------读取配置文件--------------
        if (empty(self::$data)) {
            if (is_file(INC_DAT_PATH)) {
                $datFileContents = file_get_contents(INC_DAT_PATH);
            } else {
                $datFileContents = '';
            }
            self::$data = json_decode($datFileContents, true);
        }
    }

    public function write($name, $value)
    {
        self::$data[$name] = $value;
    }

    public function read($name)
    {
        if (empty(self::$data[$name])) {
            return null;
        } else {
            return self::$data[$name];
        }
    }

    public function delete($name)
    {
        unset(self::$data[$name]);
    }

    function __destruct()
    {
        //$_SESSION['esign_userData'] = self::$data;
        $this->write2file();
    }

    public function write2file()
    {
        $s = file_put_contents(INC_DAT_PATH, Util::jsonEncode(self::$data));
        if ($s === false) {
            throw new \Exception('save data to inc.dat faiture - ' . INC_DAT_PATH);
        }
    }
}