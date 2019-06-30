<?php
/**
 * e签宝PHP SDK 入口文件
 * 支持命名空间,需php>= 5.3,php7
 *
*/
//session_start();
//生成环境，请禁用错误报告
//error_reporting(0);
error_reporting();

//定义SDK相关目录，不要随意修改
define("ESIGN_ROOT", __DIR__);
define("ESIGN_CLASS_PATH", ESIGN_ROOT . "/core/");

//调试模式，false：不打印相关日志；true、请设置日志文件目录以及读写权限
define('ESIGN_DEBUGE', true);

//日志文件目录
define("ESIGN_LOG_DIR", realpath(ESIGN_ROOT . '/../'). "/logs/");
if (ESIGN_DEBUGE && !is_dir(ESIGN_LOG_DIR)) mkdir(ESIGN_LOG_DIR, 0777);
//define("ESIGN_LOG_DIR", ESIGN_ROOT . "/logs/");
define('INC_DAT_PATH', ESIGN_ROOT .  "/comm/inc.dat");

//项目ID等配置文件
require_once(ESIGN_ROOT . "/comm/initConfig.php");

//sdk类文件自动加载
spl_autoload_register(function ($class) {
    $class_path = str_replace('tech\\', '', $class);
    $class_path = str_replace('\\', DIRECTORY_SEPARATOR, $class_path);
    $class_file = ESIGN_ROOT . DIRECTORY_SEPARATOR . $class_path . '.php';
    //echo $class_file;
    if (is_file($class_file)) {
        require_once($class_file);
    }
});




