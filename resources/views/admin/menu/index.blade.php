@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>菜单管理</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-striped table-hover bg-white text-center">
                <tr>
                    <td width="50">排序</td>
                    <td width="50">编号</td>
                    {{--<td>上级菜单</td>--}}
                    <td width="150" align="left">菜单名称</td>
                    <td>路由名称</td>
                    <td>链接地址</td>
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
                            <td>{{ $v['route']?:'无' }}</td>
                            <td>{{ $v['link']?:'无' }}</td>
                            <td>{{ $v['ico'] }}</td>
                            <td>{{ $v['items'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" onclick="AddChild({{ $v['id'] }})">添加</button>
                                <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }}, '{{ editURL('menu.update', $v['id']) }}')">编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('menu.destroy', $v['id']) }}')">删除</button>
                            </td>
                        </tr>
                        @if(isset($v['child']) && count($v['child']))
                            @foreach($v['child'] as $vv)
                                <tr>
                                    <td>{{ $vv['listorder'] }}</td>
                                    <td>{{ $vv['id'] }}</td>
                                    {{--<td>┗</td>--}}
                                    <td align="left">&nbsp;&nbsp;┗ {{ $vv['name'] }}</td>
                                    <td>{{ $vv['route']?:'无' }}</td>
                                    <td>{{ $vv['link']?:'无' }}</td>
                                    <td>{{ $vv['ico'] }}</td>
                                    <td>{{ $vv['items'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" id="edit_{{ $vv['id'] }}" data="{{ json_encode($vv) }}" onclick="Edit({{ $vv['id'] }}, '{{ editURL('menu.update', $vv['id']) }}')">编辑</button>
                                        <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('menu.destroy', $vv['id']) }}')">删除</button>
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
        </div>
    </div>
    <script>
        var createModal = '#createModal';

        function AddChild(id) {
            var json = $('#edit_' + id).attr('data');
            json = JSON.parse(json);
            $(createModal).find('select[name=pid]').val(json.id);
            //$(createModal).find('input[name=prefix]').val(json.prefix);
            $(createModal).modal('show');
        }
    </script>

    {{--delete--}}
    @include('admin.modal.delete')

    {{--create--}}
    <div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <form action="{{ route('menu.store') }}" method="POST" class="form-horizontal">
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
                            <label class="col-sm-2 control-label">路由名称</label>
                            <div class="col-sm-10">
                                <select name="route" class="form-control">
                                    <option value="">请选择</option>
                                        @foreach($routeNames as $k => $v)
                                            <option value="{{ $v }}">{{ $v }}</option>
                                        @endforeach
                                </select>
                                <span class="help-block m-b-none">若是URL地址请留空</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">链接地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="link" value="{{ old('link') }}" placeholder="">
                                <span class="help-block m-b-none">若是URL地址请填写</span>
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
                <form action="" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
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
                            <label class="col-sm-2 control-label">路由名称</label>
                            <div class="col-sm-10">
                                <select name="route" class="form-control">
                                    <option value="">请选择</option>
                                    @foreach($routeNames as $k => $v)
                                        <option value="{{ $v }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block m-b-none">若是URL地址请留空</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">链接地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="link" value="" placeholder="">
                                <span class="help-block m-b-none">若是URL地址请填写</span>
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
@endsection('content')