<?php
/**
 * User: Administrator
 * Date: 2016/12/7
 */

namespace tech\core;


class Util
{
    /**
     * 将数组转换为接送字符串，中文不转义
     * @param $array 数组
     * @return mixed|string
     */
    public static function jsonEncode($array)
    {
        $result = json_encode($array);

        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            $result = preg_replace_callback(
                "#\\\u([0-9a-f]{4})#i",
                function ($matchs) {
                    return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
                },
                $result
            );
            return $result;
        }
        return json_encode($array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * 过滤数组中的NULL元素
     *
     * @param array $arr
     * @return array
     */
    public static function filterNull(array $arr)
    {
        foreach ($arr as $k => $v) {
            if (is_null($v)) {
                unset($arr[$k]);
            } else if (is_array($arr)) {
                $arr[$k] = Util::filterNull($v);
            }
        }
        return $arr;
    }

    /**
     * 检查是否是中文编码
     * @param $str
     * @return int
     */
    public static function chkChinese($str)
    {
        return preg_match('/[\x80-\xff]./', $str);
    }

    /**
     * 检测是否windows系统，因为windows系统默认编码为GBK
     * @return bool
     */
    public static function isWin()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) == "WIN";
    }

    /**
     * 主要是由于windows系统编码是gbk，遇到中文时候，如果不进行转换处理会出现找不到文件的问题
     * @param $file_path
     * @return string
     */
    public static function encodePath($file_path)
    {
        if (self::chkChinese($file_path) && self::isWin()) {
            $file_path = iconv('utf-8', 'gbk', $file_path);
        }
        return $file_path;
    }

    /**
     * 生成指定位数的随机数
     * @param int $m 随机数位数
     * @return string 随机数字符串
     */
    public static function randStr($m = 6)
    {
        $new_str = '';
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwsyz0123456789';
        $max = strlen($str) - 1;
        for ($i = 1; $i <= $m; ++$i) {
            $new_str .= $str[mt_rand(0, $max)];
        }
        return $new_str;
    }

    /**
     * 获取服务mac地址
     * @return string $macAddr 设配地址
     */
    public static function getMacAddr()
    {
        $macAddr = '';
        $return_array = array();
        /*switch (strtolower(PHP_OS)) {
            case "linux":
                $return_array = self::forLinux();
                break;
            case "solaris":
                break;
            case "unix":
                break;
            case "aix":
                break;
            default:
                $return_array = self::forWindows();
                break;
        }
        $temp_array = array();
        foreach ($return_array as $value) {
            if (
            preg_match(
                "/[0-9a-f][0-9a-f][:-]"
                . "[0-9a-f][0-9a-f][:-]"
                . "[0-9a-f][0-9a-f][:-]"
                . "[0-9a-f][0-9a-f][:-]"
                . "[0-9a-f][0-9a-f][:-]"
                . "[0-9a-f][0-9a-f]/i",
                $value,
                $temp_array)
            ) {
                $macAddr = $temp_array[0];
                break;
            }
        }*/
        $rand = self::randStr();
        $macAddr = empty($macAddr) ? 'unknown-mac' : $macAddr;
        $macAddr = $macAddr . '-' . $rand;
        unset($temp_array);
        return $macAddr;
    }

    /**
     * 获取window下网卡信息
     * @return mixed 执行ipconfig命令返回信息
     */
    private static function forWindows()
    {
        $return_array = array();
        @exec("ipconfig /all", $return_array);
        if ($return_array)
            return $return_array;
        else {
            $ipconfig = $_SERVER["WINDIR"] . "\\system32\\ipconfig.exe";
            if (is_file($ipconfig))
                @exec($ipconfig . " /all", $return_array);
            else
                @exec($_SERVER["WINDIR"] . "\\system\\ipconfig.exe /all", $return_array);
            return $return_array;
        }
        return $return_array;
    }

    /**
     * linux系统网卡信息
     * @return mixed 执行ifconfig命令返回信息
     */
    private static function forLinux()
    {
        @exec("ifconfig -a", $return_array);
        return $return_array;
    }
}