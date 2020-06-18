<?php
/**
 * Note: 自定义函数库
 * User: Liu
 * Date: 2019/05/10
 * Time: 16:52
 */

use App\Caches\SettingCache;

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
 * @param string $disk
 * @param string $dir
 * @return mixed|string
 */
function upload_base64_thumb($thumb, $disk = 'uploads')
{
    if (strpos($thumb, 'data:image') === false) return $thumb;

    $filename = 'thumbs/'. date('Ym/').time() . rand(100, 999);//缩略图按月划分
    $fileext = str_replace('data:image/', '', strstr($thumb, ';', true));
    in_array($fileext, ['jpg', 'png', 'gif', 'bmp']) or $fileext = 'jpg';//jpeg->jpg
    $filename .= '.' . $fileext;

    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $thumb, $result)) {
        $thumbData = base64_decode(str_replace($result[1], '', $thumb));
        Storage::disk($disk)->put($filename, $thumbData);
        $thumb = $filename;
    } else {
        $thumb = '';
    }

    return $thumb;
}

/**
 * @param string $url
 * @param string $disk
 * @return string
 */
function imgurl($url = '', $disk = '')
{
    if(empty($url)) {
        return skinPath() .'images/nopic.png';
        //return skinPath() .'images/debug.jpg';
    }
    if (substr($url, 0, 4) === 'http') {
        return $url;
    }
    if ($disk) {
        return Storage::disk($disk)->url($url);
    }
    $basePath = config('admin.cdnResourcePath') ?: config('app.url');
    return $basePath . $url;
}

/**
 * 资源URL 辅助imgurl
 * @param string $url
 * @param string $disk
 * @return string
 */
function resourceUrl($url = '', $disk = 'uploads')
{
    if(empty($url)) return '';

    if (substr($url, 0, 4) === 'http') {
        return $url;
    }
    if ($disk) {
        return Storage::disk($disk)->url($url);
    }
    $basePath = config('admin.cdnResourcePath') ?: config('app.url');
    return $basePath . $url;
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
        $str .= "<script type='text/javascript' src='".skinPath()."js/plugins/editor/ueditor/ueditor.config.js'></script>";
        $str .= "<script type='text/javascript' src='".skinPath()."js/plugins/editor/ueditor/ueditor.all.js'></script>";
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

function contractTemplateEditor($content = '' , $name = 'content', $extends = '')
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
        $str .= "<script type='text/javascript' src='".skinPath()."js/plugins/editor/ueditor/ueditor.config.js'></script>";
        $str .= "<script type='text/javascript' src='".skinPath()."js/plugins/editor/ueditor/ueditor.all.js'></script>";
        $str .= "<script type='text/javascript'>
        UE.registerUI('插入一个填空选项',function(editor,uiName){
            //注册按钮执行时的command命令，使用命令默认就会带有回退操作
            editor.registerCommand(uiName,{
                execCommand:function(){
                    alert('execCommand:' + uiName)
                }
            });

            //创建一个button
            var btn = new UE.ui.Button({
                //按钮的名字
                name:uiName,
                //提示
                title:uiName,
                //需要添加的额外样式，指定icon图标，这里默认使用一个重复的icon
                cssRules :'background-position: 475px 45px;',
                //点击时执行的命令
                onclick:function () {
                    //这里可以不用执行命令,做你自己的操作也可
                    //editor.execCommand(uiName);
                    editor.execCommand('insertHtml', '".(App\Models\ContractTpl::FILL_STRING)."')
                }
            });

            //当点到编辑内容上时，按钮要做的状态反射
            editor.addListener('selectionchange', function () {
                var state = editor.queryCommandState(uiName);
                if (state == -1) {
                    btn.setDisabled(true);
                    btn.setChecked(false);
                } else {
                    btn.setDisabled(false);
                    btn.setChecked(state);
                }
            });

            //因为你是添加button,所以需要返回这个button
            return btn;
        }/*index 指定添加到工具栏上的那个位置，默认时追加到最后,editorId 指定这个UI是那个编辑器实例上的，默认是页面上所有的编辑器都会添加这个按钮*/);
        </script>";
        $str .= "<script type='text/javascript'> var ue = UE.getEditor('{$name}',{elementPathEnabled:false,contextMenu:[],enableAutoSave: false,retainOnlyLabelPasted: true, pasteplain: true,saveInterval:500000, retainOnlyLabelPasted: true, autoTransWordToList: true, toolbars: [
    ['fullscreen', 'source', 'removeformat']], fontfamily: {
    label: '',
    name: 'songti',
    val: '宋体,SimSun'
}});</script>";
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
 * @param string $message
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function responseMessage($message = '', $data = []) {
    return response()->json([
        'code' => 0,
        'message' => $message,
        'data' => $data
    ], 200)->send();
}

/**
 * @param $message
 * @param array $data
 * @param int $code
 * @return \Illuminate\Http\JsonResponse
 */
function responseException($message, $data = [], $code = 422) {
    return response()->json([
        'code' => $code,
        'message' => $message,
        'data' => $data
    ], 200)->send();
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
 * 是否调试环境
 * @return bool
 */
function is_debug_env() {
    return env('APP_DEBUG') ? true : false;
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
    // todo 账号体系完成后改掉
    return true;
    $roles = auth('admin')->user()->role;
    return array_search($roles, 1) !== false;
}

/**
 * 输出标签
 * @param $condition
 * @param $trueText
 * @param $falseText
 * @return string
 */
function colorText($condition, $trueText, $falseText = '')
{
    return '<span class="label lable-xs label-'. ($condition ? 'success' : 'danger') .' radius">'.($condition ? $trueText : $falseText).'</span>';
}


/**
 * 校验passport
 * @param $id
 * @param $secret
 * @return mixed
 */
function verifyPassportClient($id, $secret) {
    return \Cache::remember("verify_passport_client_{$id}_{$secret}", 1440, function () use ($id, $secret) {
        try {
            $client = Laravel\Passport\Client::findOrFail($id);
            if ($client->secret != $secret) {
                return false;
            }
        } catch (Exception $exception) {
            return false;
        }

        return true;
    });
}

/**
 * 发送验证码
 * @param $mobile
 * @return array
 */
function sendVerifyCode($mobile) {
    $res = SmsManager::validateSendable();
    if (!$res['success']) {
        return $res;
    }
    $data = [
        'mobile' => $mobile
    ];
    $res = SmsManager::validateFields($data);
    if (!$res['success']) {
        return $res;
    }

    return SmsManager::requestVerifySms();
}


/**
 * 隐藏字符串
 * @param $string
 * @param int $start
 * @param int $length
 * @return mixed
 */
function stringHide($string, $start = 0, $length = 0)
{
    if (empty($start)) {
        $start = floor(strlen($string) / 3);
    }
    if (empty($length)) {
        $length = ceil(strlen($string) / 3);
    }

    return substr_replace($string, str_repeat('*', $length), $start, $length);
}

if (!function_exists('getSetting')) {
    /**
     * 获取设置
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    function getSetting($key, $default = null)
    {
        return SettingCache::get($key) ?: $default;
    }
}
