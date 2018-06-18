@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>管理员管理</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-striped table-hover bg-white text-center">
                <tr>
                    {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                    <td width="50">编号</td>
                    <td>头像</td>
                    <td>用户名</td>
                    <td>昵称</td>
                    <td>邮箱</td>
                    <td width="80">管理员</td>
                    <td>创建时间</td>
                    <td>最后一次登录时间</td>
                    <td>最后一次登录IP</td>
                    <td width="120">操作</td>
                </tr>
                @if(count($lists))
                    @foreach($lists as $k=>$v)
                        <tr>
                            {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                            <td>{{ $v->id }}</td>
                            <td><img src="{{ $v->avatar }}" alt="" width="30"></td>
                            <td>{{ $v->username }}</td>
                            <td>{{ $v->truename }}</td>
                            <td>{{ $v->email }}</td>
                            <td>{{ $v->is_admin ? '是' : '否' }}</td>
                            <td>{{ $v->created_at }}</td>
                            <td>{{ $v->lasttime ? $v->lasttime : '从未登录' }}</td>
                            <td>{{ $v->lastip ? $v->lastip : '从未登录' }}</td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('manager.edit', ['id' => $v->id]) }}">编辑</a>
                                <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('manager.destroy', $v->id) }}')">删除</button>
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
            <a href="{{ route('manager.create') }}" class="btn btn-info">添加管理员</a>
            <div class="text-center">
                @if(count($lists))
                    {!! $lists->render() !!}
                @endif
            </div>
        </div>
    </div>
    {{--<a href="{{ route('manager.delete') }}" class="btn btn-warning">批量删除</a>--}}
    {{--<a class="btn btn-warning">权限管理</a>--}}
    {{--<a class="btn btn-success">模块配置</a>--}}
</div>

@include('admin.modal.delete')

@endsection('content')