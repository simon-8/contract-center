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
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">

    <table class="table table-bordered table-hover bg-white text-center">
        <tr>
            <td width="50">排序</td>
            <td width="50">编号</td>
            {{--<td>上级菜单</td>--}}
            <td width="150" align="left">菜单名称</td>
            <td>控制器</td>
            <td>方法名</td>
            <td>图标</td>
            <td width="100">子菜单数量</td>
            <td width="180">操作</td>
        </tr>
        @if(isset($lists) && count($lists) > 0)
            @foreach($lists as $v)
                <tr>
                    <td>{{ $v['listorder'] }}</td>
                    <td>{{ $v['id'] }}</td>
                    {{--<td>{{ isset($lists[$v['pid']]['name']) ? $lists[$v['pid']]['name'] : '顶级菜单' }}</td>--}}
                    <td align="left">{{ $v['name'] }}</td>
                    <td>{{ $v['prefix'] }}</td>
                    <td>{{ $v['route'] }}</td>
                    <td>{{ $v['ico'] }}</td>
                    <td>{{ $v['items'] }}</td>
                    <td>
                        <button class="btn btn-sm btn-success" onclick="AddChild({{ $v['id'] }})">添加</button>
                        <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }})">编辑</button>
                        <button class="btn btn-sm btn-danger" onclick="Delete({{ $v['id'] }})">删除</button>
                    </td>
                </tr>
                @if(isset($v['child']) && count($v['child']))
                    @foreach($v['child'] as $vv)
                        <tr>
                            <td>{{ $vv['listorder'] }}</td>
                            <td>{{ $vv['id'] }}</td>
                            {{--<td>┗</td>--}}
                            <td>&nbsp;&nbsp;┗ {{ $vv['name'] }}</td>
                            <td>{{ $vv['prefix'] }}</td>
                            <td>{{ $vv['route'] }}</td>
                            <td>{{ $vv['ico'] }}</td>
                            <td>{{ $vv['items'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" id="edit_{{ $vv['id'] }}" data="{{ json_encode($vv) }}" onclick="Edit({{ $vv['id'] }})">编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="Delete({{ $vv['id'] }})">删除</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="7">
                    未找到数据
                </td>
            </tr>
        @endif
    </table>
    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加菜单</button>
    <script>

        var deleteModal = '#deleteModal';
        var updateModal = '#updateModal';
        var createModal = '#createModal';

        function Delete(id , name)
        {
            name = name ? name : 'id';
            $(deleteModal).find('input[name='+name+']').val(id);
            $(deleteModal).modal('show');
        }

        function Edit(id)
        {

            var json = $('#edit_' + id).attr('data');
            json = JSON.parse(json);
            $.each(json , function(k , v){
                if( k == 'pid' )
                {
                    $(updateModal).find('select[name=' + k + ']').val(v);
                }
                else
                {
                    $(updateModal).find('input[name=' + k + ']').val(v);
                }
            });

            $(updateModal).modal('show');
        }
        function AddChild(id) {
            var json = $('#edit_' + id).attr('data');
            json = JSON.parse(json);
            $(createModal).find('select[name=pid]').val(json.id);
            $(createModal).find('input[name=prefix]').val(json.prefix);
            $(createModal).modal('show');
        }
    </script>

    {{--delete--}}
    @include('admin.modal.delete' , ['formurl' => route('admin.menu.delete')])

    {{--create--}}
    <div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <form action="{{ route('admin.menu.create') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">添加菜单</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">父分类</label>
                            <div class="col-sm-10">
                                <select name="pid" class="form-control">
                                    <option value="0">请选择</option>
                                    @if (isset($lists))
                                    @foreach($lists as $v)
                                        <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <span class="help-block m-b-none">选择菜单所属分类，不选择则代表一级分类</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">菜单名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="用户管理">
                                <span class="help-block m-b-none">用来显示的名称</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">路由前缀</label>
                            <div class="col-sm-10">
                                <input id="prefix" type="text" class="form-control" name="prefix" value="{{ old('prefix') }}" placeholder="Manager">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">详细路由</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="route" value="{{ old('route') }}" placeholder="getIndex">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">图标</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ico" value="{{ old('ico') }}" placeholder="fa-setting">
                                <span class="help-block m-b-none">图标</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="listorder" value="{{ old('listorder') ? old('listorder') : 0 }}" placeholder="0">
                                <span class="help-block m-b-none">越大越靠前</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">确定</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{--update--}}
    <div class="modal inmodal" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <form action="{{ route('admin.menu.update') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">编辑菜单</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">父分类</label>
                            <div class="col-sm-10">
                                <select name="pid" id="" class="form-control">
                                    <option value="0">请选择</option>
                                    @if (isset($lists))
                                    @foreach($lists as $v)
                                        <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <span class="help-block m-b-none">选择菜单所属分类，不选择则代表一级分类</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">菜单名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="" placeholder="用户管理">
                                <span class="help-block m-b-none">用来显示的名称</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">路由前缀</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="prefix" value="" placeholder="Manager">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">详细路由</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="route" value="" placeholder="getIndex">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">图标</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ico" value="" placeholder="fa-setting">
                                <span class="help-block m-b-none">图标</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="listorder" value="" placeholder="0">
                                <span class="help-block m-b-none">越大越靠前</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">确定</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 全局js -->
<script src="{{ skin_path() }}js/jquery.min.js?v=2.1.4"></script>
<script src="{{ skin_path() }}js/bootstrap.min.js?v=3.4.0"></script>

<!-- 自定义js -->
<script src="{{ skin_path() }}js/content.min.js?v=1.0.0"></script>

</body>

</html>