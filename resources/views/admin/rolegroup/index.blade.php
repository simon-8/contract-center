@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>会员组管理</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-striped table-hover bg-white text-center">
                <tr>
                    {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                    <td width="50">编号</td>
                    <td>组名</td>
                    <td>权限</td>
                    <td>状态</td>
                    <td width="120">操作</td>
                </tr>
                @if(count($lists))
                    @foreach($lists as $k=>$v)
                        <tr>
                            {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->name }}</td>
                            <td>
                                @if (count($v['access']))
                                    @foreach ($v['access'] as $vm)
                                        <span class="label label-primary">
                                        {{ $vm }}
                                    </span>&nbsp;
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $v->status ? '正常' : '关闭' }}</td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.rolegroup.update', ['id' => $v->id]) }}">编辑</a>
                                <button class="btn btn-sm btn-danger" onclick="Delete({{ $v->id }})">删除</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9">
                            暂无数据
                        </td>
                    </tr>
                @endif
            </table>
            <a href="{{ route('admin.rolegroup.create') }}" class="btn btn-info">添加会员组</a>
            <div class="text-center">
                @if(count($lists))
                    {!! $lists->render() !!}
                @endif
            </div>
        </div>
    </div>
    {{--<a href="{{ route('admin.rolegroup.delete') }}" class="btn btn-warning">批量删除</a>--}}
    {{--<a class="btn btn-warning">权限管理</a>--}}
    {{--<a class="btn btn-success">模块配置</a>--}}
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
        $(createModal).find('input[name=prefix]').val(json.prefix);
        $(createModal).modal('show');
    }
</script>

@include('admin.modal.delete' , ['formurl' => route('admin.rolegroup.delete')])

@endsection('content')