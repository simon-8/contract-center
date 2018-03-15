<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->
    <title>管理后台</title>

    <link rel="shortcut icon" href="favicon.ico">
    <link href="{{ skin_path() }}css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="{{ skin_path() }}css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="{{ skin_path() }}css/animate.min.css" rel="stylesheet">
    <link href="{{ skin_path() }}css/style.min.css?v=4.0.0" rel="stylesheet">
    <script src="{{ skin_path() }}js/jquery.min.js?v=2.1.4"></script>
    <script>
        var AJPath = '{{ route('admin.ajax.index') }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
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
                @include('admin.public.mail_box')
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i></button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="{{ route('admin.index.index') }}">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRefresh" title="刷新当前页面"><i class="fa fa-refresh"></i></button>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button>
            <button class="roll-nav roll-right dropdown J_tabClose">
                <span class="dropdown-toggle" data-toggle="dropdown">关闭操作<span class="caret"></span></span>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                    </li>
                </ul>
            </button>
            <a href="login.html" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{ route('admin.index.index') }}"
                    frameborder="0" data-id="{{ route('admin.index.index') }}" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">
                &copy; {{ date('Y') - 1 }}-{{ date('Y') + 1 }}
                <a href="{{ route('admin.index.index') }}" target="_blank">zihan's blog</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
    @include('admin.public.right_side')
    <!--右侧边栏结束-->
    <!--mini聊天窗口开始-->
    @include('admin.public.mini_chat')
    <!--mini聊天窗口结束-->
</div>

<script src="{{ skin_path() }}js/bootstrap.min.js?v=3.3.5"></script>
<script src="{{ skin_path() }}js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="{{ skin_path() }}js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ skin_path() }}js/plugins/layer/layer.min.js"></script>
<script src="{{ skin_path() }}js/manage.js?v=4.0.0"></script>
<script type="text/javascript" src="{{ skin_path() }}js/contabs.min.js"></script>
<script src="{{ skin_path() }}js/plugins/pace/pace.min.js"></script>
</body>
</html>