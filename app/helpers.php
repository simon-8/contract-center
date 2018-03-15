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

/**
 * 返回等比例缩放后的高度
 * @param $width
 * @param $newWidth
 * @param $height
 * @return float|int
 */
function calcHeight($width, $newWidth, $height)
{
    $scale = $newWidth/$width;
    return $height * $scale;
}

/**
 * 上传base64编码的缩略图
 * @param $thumb
 * @return string
 */
function upload_base64_thumb($thumb)
{
    if (strpos($thumb, 'data:image') === false) return $thumb;

    $filepath = public_path() . '/uploads/thumbs/' . date('Ym') . '/';//缩略图按月划分
    $filename = time() . rand(100, 999);
    $fileext = str_replace('data:image/', '', strstr($thumb, ';', true));
    in_array($fileext, ['jpg', 'png', 'gif', 'bmp']) or $fileext = 'jpg';//jpeg->jpg
    $filename .= '.' . $fileext;

    if (!\File::isDirectory($filepath)) {
        \File::makeDirectory($filepath, 0777, true);
    }
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $thumb, $result)) {
        \File::put($filepath . $filename, base64_decode(str_replace($result[1], '', $thumb)));
        $thumb = \File::exists($filepath . $filename) ? $filepath . $filename : '';
        $thumb = str_replace(public_path(), '', $thumb);//path => ''
    } else {
        $thumb = '';
    }

    return $thumb;
}

function imgurl($url)
{
    return config('app.url') . $url;
}