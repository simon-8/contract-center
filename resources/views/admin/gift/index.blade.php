@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <table class="table table-bordered table-hover bg-white text-center">
        <tr>
            {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
            <td width="50">编号</td>
            <td>奖品</td>
            <td>简介</td>
            <td>图片</td>
            <td>等级</td>
            <td width="80">库存</td>
            <td>已抽中</td>
            <td>状态</td>
            <td>创建时间</td>
            <td>编辑时间</td>
            <td width="120">操作</td>
        </tr>
        @if(count($lists))
            @foreach($lists as $k=>$v)
                <tr>
                    {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->name }}</td>
                    <td>{{ $v->introduce ? $v->introduce : '无' }}</td>
                    <td><a class="fa fa-file-image-o" onclick="preview('{!! imgurl($v->thumb) !!}', 150, 150)" title="点击查看缩略图"></a></td>
                    <td>{{ $v->level }}</td>
                    <td>{{ $v->amount }}</td>
                    <td>{{ $v->sales }}</td>
                    <td>{{ $v->status ? '正常' : '关闭' }}</td>
                    <td>{{ $v->created_at }}</td>
                    <td>{{ $v->updated_at }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('admin.gift.update', ['id' => $v->id]) }}">编辑</a>
                        <button class="btn btn-sm btn-danger" onclick="Delete({{ $v->id }})">删除</button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11">
                    暂无数据
                </td>
            </tr>
        @endif
    </table>
    <a href="{{ route('admin.gift.create') }}" class="btn btn-info">添加奖品</a>
    <div class="text-center">
        @if(count($lists))
            {!! $lists->render() !!}
        @endif
    </div>
    {{--<a href="{{ route('admin.gift.delete') }}" class="btn btn-warning">批量删除</a>--}}
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

@include('admin.modal.delete' , ['formurl' => route('admin.gift.delete')])

@endsection('content')