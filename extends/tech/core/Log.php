<?php
/**
 * User: esign
 * Date: 2016/10/19
 */
namespace tech\core;

class Log
{
    private static $debug_fp = false;

    public static function debug($str)
    {
        if (self::$debug_fp === false) {
            self::$debug_fp = @fopen(ESIGN_LOG_DIR . '/debug-' . date('Y-m-d') . '.log', 'a+');
        }
        $fp = self::$debug_fp;

        if ($fp !== false) {
            $log_str = date('Y-m-d H:i:s') . ' > ' . $str . PHP_EOL;
            fwrite($fp, $log_str, strlen($log_str));
        }
    }


}