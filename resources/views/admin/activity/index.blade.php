@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>活动管理</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-hover bg-white text-center">
                <tr>
                    {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                    <td width="50">编号</td>
                    <td>活动名</td>
                    <td>开始时间</td>
                    <td>开奖时间</td>
                    <td width="80">参与人数</td>
                    <td>参与人数限制</td>
                    <td>状态</td>
                    <td>创建时间</td>
                    <td>编辑时间</td>
                    <td width="380">操作</td>
                </tr>
                @if(count($lists))
                    @foreach($lists as $k=>$v)
                        <tr>
                            {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->start_time }}</td>
                            <td>{{ $v->end_time }}</td>
                            <td>{{ $v->actor }}</td>
                            <td>{{ $v->max_actor }}</td>
                            <td>{{ $v->status ? '正常' : '关闭' }}</td>
                            <td>{{ $v->created_at }}</td>
                            <td>{{ $v->updated_at }}</td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('home.activity.show', ['id' => encrypt($v->id)]) }}" target="_blank">进入开奖</a>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.ad.item.index', ['pid' => $v->AdPlace()->first()->id]) }}">Banner管理</a>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.gift.index', ['aid' => $v->id]) }}">奖品管理</a>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.activity.update', ['id' => $v->id]) }}">编辑</a>
                                <button class="btn btn-sm btn-danger" onclick="Delete({{ $v->id }})">删除</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">
                            暂无数据
                        </td>
                    </tr>
                @endif
            </table>
            <a href="{{ route('admin.activity.create') }}" class="btn btn-info">添加活动</a>
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