@extends('layout.admin')
@section('content')
<div class="col-sm-8 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>获奖名单</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-hover bg-white text-center">
                <tr>
                    {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                    <td width="50">编号</td>
                    <td>活动ID</td>
                    <td>活动名称</td>
                    <td>姓名</td>
                    <td>电话</td>
                    <td>奖品名</td>
                    <td>奖品等级</td>
                    <td>获奖时间</td>
                    {{--<td>编辑时间</td>--}}
                    {{--<td width="380">操作</td>--}}
                </tr>
                @if(count($lists))
                    @foreach($lists as $k=>$v)
                        <tr>
                            {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->Activity->id }}</td>
                            <td>{{ $v->Activity->name }}</td>
                            <td>{{ $v->truename }}</td>
                            <td>{{ $v->mobile }}</td>
                            <td>{{ $v->gname }}</td>
                            <td>{{ $v->Gift->level }}</td>
                            <td>{{ $v->created_at }}</td>
                            {{--<td>{{ $v->updated_at }}</td>--}}
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">
                            暂无数据
                        </td>
                    </tr>
                @endif
            </table>
            <a href="{{ route('admin.activity.index') }}" class="btn btn-info">返回活动列表</a>
            <div class="text-center">
                @if(count($lists))
                    {!! $lists->render() !!}
                @endif
            </div>
        </div>
    </div>
    {{--<a href="{{ route('admin.activity.delete') }}" class="btn btn-warning">批量删除</a>--}}
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

@include('admin.modal.delete' , ['formurl' => route('admin.activity.delete')])

@endsection('content')