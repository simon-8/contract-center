@extends('layout.admin')
@section('content')
<div class="col-sm-6 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>权限管理</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-striped table-hover bg-white text-center">
                <tr>
                    <td width="50">编号</td>
                    {{--<td>上级权限</td>--}}
                    <td width="150" align="left">权限名称</td>
                    <td>请求类型</td>
                    <td>URL路径</td>
                    <td width="180">操作</td>
                </tr>
                @if(isset($lists) && count($lists) > 0)
                    @foreach($lists as $v)
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            {{--<td></td>--}}
                            <td align="left">{{ $v['name'] }}</td>
                            <td>
                                @if ($v['method'])
                                    @foreach ($v['method'] as $vm)
                                    <span class="label label-primary">
                                        {{ $vm }}
                                    </span>&nbsp;
                                    @endforeach
                                @else
                                    <span class="label label-primary">
                                        ALL
                                    </span>
                                @endif
                            </td>
                            <td>{{ $v['path'] }}</td>
                            <td>
                                <a class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" href="{{ route('admin.roleaccess.update', ['id' => $v['id']]) }}">编辑</a>
                                <button class="btn btn-sm btn-danger" onclick="Delete({{ $v['id'] }})">删除</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">
                            未找到权限
                        </td>
                    </tr>
                @endif
            </table>
            <a class="btn btn-success" href="{{ route('admin.roleaccess.create') }}">添加权限</a>
            @if(count($lists))
                <div class="text-center">
                    {!! $lists->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>
<div class="col-sm-6 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>权限管理</h5>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="{{ isset($id) ? route('admin.manager.update') : route('admin.manager.create') }}" id="sform">
                <div class="form-group">
                    <label class="col-sm-2 control-label">权限名称</label>
                    <div class="col-sm-10">
                        <input id="username" type="text" class="form-control" name="username" value="{{ isset($username) ? $username : old('username') }}">
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">请求路径</label>
                    <div class="col-sm-10">
                        <input id="username" type="text" class="form-control" name="username" value="{{ isset($username) ? $username : old('username') }}">
                        <span class="help-block m-b-none">支持*</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group role-div">
                    <label class="col-sm-2 control-label">请求类型</label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            @foreach(['GET','POST','PUT','DELETE'] as $v)
                                <label>
                                    <input type="checkbox" class="i-checks" name="role[]" value="$v" {{ (isset($role) && in_array($menu['id'], $role)) ? 'checked' : '' }}>{{ $v }}
                                </label>
                            @endforeach
                        </div>
                        <span class="help-block m-b-none">留空表示所有请求类型</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存内容</button>
                        <a class="btn btn-white" href="{{ route('admin.manager.index') }}">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
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
            $(updateModal).find('[name=' + k + ']').val(v);
        });

        $(updateModal).modal('show');
    }
    function AddChild(id) {
        var json = $('#edit_' + id).attr('data');
        json = JSON.parse(json);
        $(createModal).find('select[name=pid]').val(json.id);
        //$(createModal).find('input[name=prefix]').val(json.prefix);
        $(createModal).modal('show');
    }
</script>

{{--delete--}}
@include('admin.modal.delete' , ['formurl' => route('admin.roleaccess.delete')])

@endsection('content')