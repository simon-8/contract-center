<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi">
    <meta name="renderer" content="webkit">
    <title>酒店管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ skinPath() }}css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ skinPath() }}css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ skinPath() }}css/animate.min.css" rel="stylesheet">
    <link href="{{ skinPath() }}css/style.min.css" rel="stylesheet">
    <link href="{{ skinPath() }}css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">

    <!-- 全局js -->
    <script src="{{ skinPath() }}js/jquery.min.js"></script>
    <script src="{{ skinPath() }}js/bootstrap.min.js"></script>

    <!-- 自定义js -->
    <script src="{{ skinPath() }}js/plugins/layer/layer.min.js"></script>
    <script src="{{ skinPath() }}js/plugins/laydate/laydate.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

    <script>
        var AJPath = '{{ route('ajax.index') }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $('.switch').bootstrapSwitch({
                //onText : "上线",
                //offText : "下线",
                onColor : "success",
                offColor : "danger",
                size : "small",
            });

            //模态框中的表单提交时开始loading动画
            //$('.modal form [type=submit], #sform [type=submit]').click(function(){
            //    loading();
            //});
        });
    </script>
</head>

<body class="gray-bg">
<div class="container">
    <div class="row">
        @include('wechat.public.message')
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

{{--<script src="{{ skinPath() }}js/content.min.js"></script>--}}
<script src="{{ skinPath() }}js/plugins/iCheck/icheck.min.js"></script>
{{--<script src="{{ skinPath() }}js/plugins/switch/bootstrap-switch.min.js"></script>--}}

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
                area: ['100%', '100%'],
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

    function Delete(url)
    {
        var deleteModal = '#deleteModal';
        $(deleteModal).find('form#deleteForm').attr('action', url);
        $(deleteModal).modal('show');
    }

    function Edit(id, url)
    {
        var updateModal = '#updateModal';
        var json = $('#edit_' + id).attr('data');
        json = JSON.parse(json);
        $.each(json , function(k , v){
            $(updateModal).find('[name=' + k + ']').val(v);
        });
        $(updateModal).find('form').attr('action', url);
        $(updateModal).modal('show');
    }

    /*
    * 加载层
    * */
    function loading(close) {
        Boolean(close) ? $('#loadding_box').fadeOut(300) : $('#loadding_box').fadeIn(300);
    }
    loading(true);
</script>
</body>
</html>