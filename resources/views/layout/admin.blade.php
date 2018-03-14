<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>H+ 后台主题UI框架 - 首页示例二</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link href="{{ skin_path() }}css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="{{ skin_path() }}css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="{{ skin_path() }}css/animate.min.css" rel="stylesheet">
    <link href="{{ skin_path() }}css/style.min.css?v=4.0.0" rel="stylesheet">
    <link href="{{ skin_path() }}css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- 全局js -->
    <script src="{{ skin_path() }}js/jquery.min.js?v=2.1.4"></script>
    <script src="{{ skin_path() }}js/bootstrap.min.js?v=3.4.0"></script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        @include('admin.public.message')
        @yield('content')
    </div>
</div>


<!-- 自定义js -->
<script src="{{ skin_path() }}js/plugins/iCheck/icheck.min.js"></script>
<script src="{{ skin_path() }}js/plugins/layer/layer.min.js"></script>
<script src="{{ skin_path() }}js/content.min.js?v=1.0.0"></script>
<script>
    function preview(src,w,h,t){
        var t = t ? t : '图片预览';
        if( src ){
            var w = w+0;
            var h = h+42;
            layer.open({
                area:[w+'px',h+'px'],
                type:1,
                title:t,
                shadeClose:true,
                content:"<img src='"+src+"'/>"
            });
        }
    }

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    //模态框中的表单提交时开始loading动画
    $('.modal form [type=submit]').click(function(){
        loading();
    });
</script>

</body>

</html>