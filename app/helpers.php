<?php
/**
 * Note: 自定义函数库
 * User: Liu
 * Date: 2018/3/11
 * Time: 16:52
 */

/**
 * 载入admin目录模板
 * @param $template
 * @return mixed
 */
function admin_view($template)
{
    $params = func_get_args();//获取函数传入的参数列表 数组
    $params[0] = 'admin.'.$params[0];
    return call_user_func_array('view' ,$params );//调用回调函数，并把一个数组参数作为回调函数的参数
}

/**
 * 载入home目录模板
 * @param $template
 * @return mixed
 */
function home_view($template)
{
    $params = func_get_args();//获取函数传入的参数列表 数组
    $params[0] = 'home.'.$params[0];
    return call_user_func_array('view' ,$params );//调用回调函数，并把一个数组参数作为回调函数的参数
}

/**
 * 获取资源路径
 * @param string $module
 * @return string
 */
function skin_path($module = 'admin')
{
    $path = '';
    switch ($module) {
        case 'admin':
            $path = '/manage/';
            break;
        default:
            break;
    }
    return $path;
}

/**
 * 根据route名称返回URL
 * @param $route
 * @return string
 */
function routeNoCatch($route = '')
{
    if(empty($route)) return '/';
    try{
        return route($route);
    }catch (\Exception $exception) {
        return '';
    }
}