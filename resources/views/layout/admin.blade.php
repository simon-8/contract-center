<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ skin_path() }}css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="{{ skin_path() }}css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="{{ skin_path() }}css/animate.min.css" rel="stylesheet">
    <link href="{{ skin_path() }}css/style.min.css?v=4.0.0" rel="stylesheet">
    <link href="{{ skin_path() }}css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- 全局js -->
    <script src="{{ skin_path() }}js/jquery.min.js?v=2.1.4"></script>
    <script src="{{ skin_path() }}js/bootstrap.min.js?v=3.4.0"></script>
    <script>
        var AJPath = '{{ route('admin.ajax.index') }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        @include('admin.public.message')
        @yield('content')
    </div>
    <div id="loadding_box">
        <div id="loadding_animate" class="sk-spinner sk-spinner-cube-grid">
            <div class="sk-cube"></div>
            <div class="sk-cube"></div>
            <div class="sk-cube"></div>
            <div class="sk-cube"></div>
            <div class="sk-cube"></div>
            <div class="sk-cube"></div>
            <div class="sk-cube"></div>
            <div class="sk-cube"></div>
            <div class="sk-cube"></div>
        </div>
    </div>
</div>

<!-- 自定义js -->
<script src="{{ skin_path() }}js/plugins/iCheck/icheck.min.js"></script>
<script src="{{ skin_path() }}js/plugins/layer/layer.min.js"></script>
<script src="{{ skin_path() }}js/content.min.js?v=1.0.0"></script>
<script>

    function thumbCallback(url,i){
        $('#'+i).val(url);
        try{
            $('#p'+i).attr('src',url);
        }catch(e){}
    }

    function Sthumb(i, w, h) {
        $.post(AJPath, {ac: 'thumb', i: i, w: w, h: h, c: 'thumbCallback'}, function (data) {
            layer.open({
                area: '800px',
                title: '上传图片',
                type: 1,
                content: data
            })
        });
    }

    function preview(src, w, h, t) {
        t = t ? t : '图片预览';
        if (src) {
            w = w + 0;
            h = h + 42;
            layer.open({
                area: [w + 'px', h + 'px'],
                type: 1,
                title: t,
                shadeClose: true,
                content: "<img src='" + src + "'/>"
            });
        }
    }

    /*
    * 加载层
    * */
    function loading(close) {
        Boolean(close) ? $('#loadding_box').fadeOut(800) : $('#loadding_box').fadeIn(800);
    }
    loading();
    $(function() {
        loading(true);
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        //模态框中的表单提交时开始loading动画
        $('.modal form [type=submit], #sform [type=submit]').click(function(){
            loading();
        });
    });
</script>

</body>

</html>