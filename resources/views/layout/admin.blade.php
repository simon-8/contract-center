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
    <script src="{{ skinPath() }}js/plugins/layer/layer.js"></script>
    <script src="{{ skinPath() }}js/plugins/laydate/laydate.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

    <script>
        var AJPath = '{{ route('admin.ajax.index') }}';
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

<script src="{{ skinPath() }}js/content.min.js"></script>
<script src="{{ skinPath() }}js/plugins/iCheck/icheck.min.js"></script>
{{--<script src="{{ skinPath() }}js/plugins/switch/bootstrap-switch.min.js"></script>--}}
<script>
    $(document).ready(function(){
        $('img').each(function(){
            var error = false;
            if (!this.complete) {
                error = true;
            }

            if (typeof this.naturalWidth != "undefined" && this.naturalWidth == 0) {
                error = true;
            }

            if(error){
                $(this).bind('error.replaceSrc',function(){
                    this.src = "{{ imgurl() }}";

                    $(this).unbind('error.replaceSrc');
                }).trigger('load');
            }
        });
    });
</script>
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

    function openFrame(obj, href, page, name) {
        let create = true;
        $(".J_menuTab", parent.document).each(function () {
            if ($(this).data('id') === page) {
                if (!$(this).hasClass('active')) {
                    $(this).addClass("active").siblings(".J_menuTab").removeClass("active");
                    $(".J_mainContent .J_iframe", parent.document).each(function () {
                        if ($(this).data("id") === page) {
                            $(this).show().siblings(".J_iframe").hide();
                            if ($(this).attr('src') != href) {
                                $(this).attr('src', href);
                            }
                        }
                        //return $(this).data("id") === page ? $(this).show().siblings(".J_iframe").hide() : '';
                    });
                    create = false;
                }
                $(this).html(name + ' <i class="fa fa-times-circle"></i>');
            }
        });
        if (create) {
            var menu = '<a href="javascript:;" class="active J_menuTab" data-id="' + page + '">' + name + ' <i class="fa fa-times-circle"></i></a>';
            $(".J_menuTab", parent.document).removeClass("active");
            var iframe = '<iframe class="J_iframe" name="iframe' + page + '" width="100%" height="100%" src="' + href + '" frameborder="0" data-id="' + page + '" seamless></iframe>';
            $(".J_menuTabs .page-tabs-content", parent.document).append(menu);
            $(".J_mainContent", parent.document).find("iframe.J_iframe").hide().parents(".J_mainContent").append(iframe);
        }
    }

    /*
    * 加载层
    * */
    function loading(close) {
        Boolean(close) ? $('#loadding_box').fadeOut() : $('#loadding_box').fadeIn();
    }
    loading(true);
</script>
</body>
</html>
