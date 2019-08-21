<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>管理后台</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    {{--<link rel="shortcut icon" href="favicon.ico">--}}
    <link href="{{ skinPath() }}css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ skinPath() }}css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ skinPath() }}css/animate.min.css" rel="stylesheet">
    <link href="{{ skinPath() }}css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ skinPath() }}css/plugins/toastr/toastr.min.css">

    <script src="{{ skinPath() }}js/jquery.min.js"></script>
    <script src="{{ skinPath() }}js/bootstrap.min.js"></script>
    <script src="{{ skinPath() }}js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ skinPath() }}js/plugins/toastr/toastr.min.js"></script>
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    @include('admin.public.navbar')
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    {{--<form role="search" class="navbar-form-custom" method="post" action="search_results.html">--}}
                        {{--<div class="form-group">--}}
                            {{--<input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">--}}
                        {{--</div>--}}
                    {{--</form>--}}
                </div>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="#" class="active J_menuTab" data-id="{{ route('admin.index.main') }}">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRefresh" title="刷新当前页面"><i class="fa fa-refresh"></i></button>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button>
            <button class="roll-nav roll-right dropdown J_tabClose">
                <span class="dropdown-toggle" data-toggle="dropdown">关闭操作<span class="caret"></span></span>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    {{--<li class="J_tabShowActive"><a>定位当前选项卡</a></li>--}}
                    {{--<li class="divider"></li>--}}
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a></li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a></li>
                </ul>
            </button>
            <a href="{{ route('admin.logout') }}" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main" style="-webkit-overflow-scrolling: touch;overflow-y: scroll;">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{ route('admin.index.main') }}" frameborder="0" data-id="{{ route('admin.index.main') }}" seamless scrolling="no"></iframe>
            <style>
                .J_iframe {
                    width: 1px !important;min-width: 100%;*width: 100%;
                }
            </style>
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
        <div class="footer">
            <div class="pull-right">
                &copy; {{ date('Y') - 1 }}-{{ date('Y') + 1 }}
                <a>SCMS</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
    {{--@include('admin.public.right_side')--}}
    <!--右侧边栏结束-->
    <!--mini聊天窗口开始-->
    {{--@include('admin.public.mini_chat')--}}
    <!--mini聊天窗口结束-->
</div>

<!-- <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script> -->
<script src="{{ skinPath() }}js/plugins/layer/layer.js"></script>
<script src="{{ skinPath() }}js/admin.js"></script>
<script type="text/javascript" src="{{ skinPath() }}js/contabs.min.js"></script>
<!-- <script type="text/javascript" src="js/contabs.min.js"></script> -->
<!-- <script src="js/plugins/pace/pace.min.js"></script> -->
<script>
    function toastrMessage(content, title, second, clickFunc) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "onclick": (typeof clickFunc === 'function' ? clickFunc : false),
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": (second ? second : 5) * 1000,
            "extendedTimeOut": 0,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.info(title ? title : '系统提示', content);
    }
</script>
</body>
</html>
