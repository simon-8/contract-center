@inject('authService', 'App\Services\AuthService')

@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>权限管理</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-nowrap bg-white text-center">
                <tr>
                    <td width="50">编号</td>
                    <td width="150" align="left">权限名称</td>
                    <td>请求类型</td>
                    <td>路由地址</td>
                    <td width="180">操作</td>
                </tr>
                @empty($lists)
                    <tr>
                        <td colspan="5">
                            未找到权限
                        </td>
                    </tr>
                @else
                    @foreach($lists as $v)
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            {{--<td></td>--}}
                            <td align="left">{{ $v['name'] }}</td>
                            <td>

                            </td>
                            <td>{{ $v['name'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }}, '{{ editURL('permission.update', $v['id']) }}')">编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('permission.destroy', $v['id']) }}')">删除</button>
                            </td>
                        </tr>
                    @endforeach
                @endempty
            </table>
            </div>
            <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加权限</button>
            @if(!empty($lists))
                <div class="text-center">
                    {!! $lists->render() !!}
                </div>
            @endif
        </div>
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
        <div class="modal-content animated bounceInDown">
            <form action="{{ route('permission.store') }}" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加权限</h4>
                    {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">权限名</label>
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
                                @foreach($authService->getRoutes() as $k => $v)
                                    <option value="{{ $k }}">{{ __("routes.{$k}") }}</option>
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
        <div class="modal-content animated bounceInDown">
            <form action="" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                <input type="hidden" name="id" value="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">编辑权限</h4>
                    {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">权限名</label>
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
                                @foreach($authService->getRoutes() as $k => $v)
                                    <option value="{{ $k }}">{{ __("routes.{$k}") }}</option>
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
@endsection('content')