@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="mail-box-header">

        <form method="get" action="{{ route('admin.user.index') }}" class="pull-right mail-search">
            <div class="input-group">
                <input type="text" class="form-control input-sm" name="keyword" placeholder="请输入用户姓名或手机号查询" value="{{ $keyword }}">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-sm btn-primary">
                        搜索
                    </button>
                </div>
            </div>
        </form>
        <h2>
            用户管理
        </h2>
        {{--<div class="mail-tools tooltip-demo m-t-md">--}}
            {{--<div class="btn-group pull-right">--}}
                {{--<button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i>--}}
                {{--</button>--}}
                {{--<button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i>--}}
                {{--</button>--}}

            {{--</div>--}}
            {{--<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="刷新邮件列表"><i class="fa fa-refresh"></i> 刷新</button>--}}
            {{--<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="标为已读"><i class="fa fa-eye"></i>--}}
            {{--</button>--}}
            {{--<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="标为重要"><i class="fa fa-exclamation"></i>--}}
            {{--</button>--}}
            {{--<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="标为垃圾邮件"><i class="fa fa-trash-o"></i>--}}
            {{--</button>--}}

        {{--</div>--}}
    </div>

    <table class="table table-bordered table-hover bg-white text-center">
        <tr>
            {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
            <td width="50">编号</td>
            <td>头像</td>
            <td>姓名</td>
            <td>手机号</td>
            <td>昵称</td>
            <td>城市</td>
            <td>创建时间</td>
            <td>编辑时间</td>
            <td width="120">操作</td>
        </tr>
        @if(count($lists))
            @foreach($lists as $k=>$v)
                <tr>
                    {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                    <td>{{ $v->id }}</td>
                    <td><img src="{{ $v->avatar }}" alt="" width="40" height="40"></td>
                    <td>{{ $v->truename }}</td>
                    <td>{{ $v->mobile }}</td>
                    <td>{{ $v->nickname }}</td>
                    <td>{{ $v->city }}</td>
                    <td>{{ $v->created_at }}</td>
                    <td>{{ $v->updated_at }}</td>
                    <td>
                        {{--<a class="btn btn-sm btn-info" href="{{ route('admin.user.update', ['id' => $v->id]) }}">编辑</a>--}}
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
    <div class="text-center">
        @if(count($lists))
            {!! $lists->render() !!}
        @endif
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
        $(createModal).find('input[name=prefix]').val(json.prefix);
        $(createModal).modal('show');
    }
</script>

@include('admin.modal.delete' , ['formurl' => route('admin.user.delete')])

@endsection('content')