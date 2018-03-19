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

/**
 *
 * @param $url
 * @return string
 */
function imgurl($url)
{
    return config('app.url') . $url;
}


/**
 * validate.js
 * @return string
 */
function jquery_validate_js()
{
    return <<<php
    <script src="/manage/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/manage/js/plugins/validate/messages_zh.min.js"></script>
php;
}

/**
 * 生成jquery.validate的默认设置
 * @return string
 */
function jquery_validate_default()
{
    $js = <<<php
    $.validator.setDefaults({
        highlight: function(a) {
            $(a).closest(".form-group").removeClass("has-success").addClass("has-error")
        },
        success: function(a) {
            a.closest(".form-group").removeClass("has-error").addClass("has-success")
        },
        errorElement: "span",
        errorPlacement: function(a, b) {
            if (b.is(":radio") || b.is(":checkbox")) {
                a.appendTo(b.parent().parent().parent())
            } else {
                a.appendTo(b.parent())
            }
        },
        errorClass: "help-block m-b-none",
        validClass: "help-block m-b-none"
    });
php;
    return $js;

}

function number2text($number) {
    $len = strlen($number);
    switch ($number) {
        case 1:
            return '一';
            break;
        case 2:
            return '二';
            break;
        case 3:
            return '三';
            break;
        case 4:
            return '四';
            break;
        case 5:
            return '五';
            break;
        case 6:
            return '六';
            break;
        case 7:
            return '七';
            break;
        case 8:
            return '八';
            break;
        case 9:
            return '九';
            break;
        default:
            break;
    }
}
