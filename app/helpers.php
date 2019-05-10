<?php
/**
 * Note: 自定义函数库
 * User: Liu
 * Date: 2019/05/10
 * Time: 16:52
 */

/**
 * 获取资源路径
 * @param string $module
 * @return string
 */
function skinPath($module = 'admin')
{
    $domain = config('admin.cdnResourcePath') ?: config('app.url');
    $path = $domain .'/'. strtolower($module) .'/';
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
    if(empty($url)) {
        return '/manage/images/nopic.png';
    }
    return substr($url, 0, 4) === 'http' ? $url : config('app.url') . $url;
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

/**
 * 调用编辑器
 * @param string $content
 * @param string $name
 * @param string $extends
 * @return bool
 */
function seditor($content = '' , $name = 'content', $extends = '')
{
    $editor = env('WEB_EDITOR', 'ueditor');
    $str = '';
    if ($editor == 'kindeditor') {
        $url = "/plugins/editor/kindeditor/kindeditor.js";
        $lang = "/plugins/editor/kindeditor/lang/zh_CN.js";
        $str .= "<script charset='utf-8' src='$url'></script>";
        $str .= "<script charset='utf-8' src='$lang'></script>";
        $str .= "<script>";
        $str .= " KindEditor.ready(function(K) { window.editor = K.create('#$name',{width:'100%',cssPath : '/plugins/editor/kindeditor/plugins/code/new.css',resizeMode:0});});";
        $str .= "</script>";
        return $str;
    } else if ($editor == 'ueditor') {
        $str .= "<script id='content' type='text/plain' style='width:100%;height:500px;' name='{$name}' {$extends}>" . $content . "</script>";
        $str .= "<script type='text/javascript' src='/manage/plugins/editor/ueditor/ueditor.config.js'></script>";
        $str .= "<script type='text/javascript' src='/manage/plugins/editor/ueditor/ueditor.all.js'></script>";
        $str .= "<script type='text/javascript'> var ue = UE.getEditor('{$name}',{elementPathEnabled:false,contextMenu:[],enableAutoSave: false,saveInterval:500000});</script>";
        return $str;

    } else if ($editor == 'markdown') {
        //echo "<textarea name='" . $name . "' data-provide='markdown' {$extends} rows='10'>" . $content . "</textarea>";
        //echo "<link rel='stylesheet' type='text/css' href='/manage/css/plugins/markdown/bootstrap-markdown.min.css' />";
        //echo "<script type='text/javascript' src='/manage/plugins/editor/markdown/markdown.js'></script>";
        //echo "<script type='text/javascript' src='/manage/plugins/editor/markdown/to-markdown.js'></script>";
        //echo "<script type='text/javascript' src='/manage/plugins/editor/markdown/bootstrap-markdown.js'></script>";
        //echo "<script type='text/javascript' src='/manage/plugins/editor/markdown/bootstrap-markdown.zh.js'></script>";
        $str .= "<div id='{$name}'><textarea name='{$name}' style='display:none;'>{$content}</textarea></div>";
        $str .= view('markdown::encode', ['editors'=>[$name]]);
        return $str;
    }
    return false;
}

function is_markdown()
{
    return env('WEB_EDITOR') === 'markdown' ? 1 : 0;
}

/**
 * 查找数组中是否包含指定的value
 * @param $val
 * @param $arr
 * @return bool
 */
function array_search_value($val, $arr) {
    $result = false;
    if (array_search($val, $arr) !== false) {
        $result = true;
    }
    if (!$result) {
        foreach ($arr as $v) {
            if (substr($val, 0, strlen($v)) === $v) {
                $result = true;
            }
        }
    }
    return $result;
}

/**
 * @param $message
 * @param array $data
 * @param int $status
 * @return \Illuminate\Http\JsonResponse
 */
function response_message($message, $data = [], $status = 0) {
    return response()->json([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ], 200);
}

/**
 * @param $message
 * @param array $data
 * @param int $status
 * @return \Illuminate\Http\JsonResponse
 */
function response_exception($message, $data = [], $status = 422) {
    return response()->json([
        'status' => 0,
        'message' => $message,
        'data' => $data
    ], $status);
}

function editURL($route, $id, $name = 'id') {
    return route($route, [$name => $id]);
}

/**
 * @return bool
 */
function is_testing_env() {
    return env('APP_ENV') === 'testing';
}

/**
 * id加密
 * @param $id
 * @return mixed
 */
function id_encode($id) {
    return app(\Delight\Ids\Id::class)->obfuscate($id);
}

/**
 * id解密
 * @param $id
 * @return mixed
 */
function id_decode($id) {
    return app(\Delight\Ids\Id::class)->deobfuscate($id);
}


/**
 * 跳转URL
 * @param $url
 * @return string
 */
function get_redirect_url($url) {
    return config('app.url') . '/redirect?url=' . urlencode($url);
}

/**
 * @return array|string
 */
function smart_get_client_ip() {
    $request = request();
    $clientIp = $request->ip();
    //七牛CDN获取源IP
    if ($request->server('HTTP_X_FROM_CDN') && $request->server('HTTP_X_FORWARDED_FOR')) {
        $clientIp = $request->server('HTTP_X_FORWARDED_FOR');
    }

    return $clientIp;
}


function ConverTimeToDHMS($seconds)
{
    $seconds=(int)$seconds;
    if($seconds<=0){
        return '0秒';
    }
    $day = floor($seconds / 0x15180);
    $hour = floor(($seconds % 0x15180 ) / 0xe10);
    $minute = floor( ( $seconds % 0xe10 ) / 60 );
    $second = $seconds % 60;
    $str='';
    if($day>0){
        $str.=sprintf("%d天", $day);
    }
    if($hour>0){
        $str.=sprintf("%d小时", $hour);
    }
    if($minute>0){
        $str.=sprintf("%d分钟", $minute);
    }
    if($second>0){
        $str.=sprintf("%d秒", $second);
    }
    if($str==''){
        $str='0秒';
    }
    return $str;
}


/**
 * 是否是超级管理员
 * @return bool
 */
function is_superadmin()
{
    $is_superadmin = false;
    $roles = auth('admin')->user()->role;
    foreach ($roles as $role) {
        if ($role == 1) {
            $is_superadmin = true;
            continue;
        }
    }
    return $is_superadmin;
}