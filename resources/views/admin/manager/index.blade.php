@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>管理员管理</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-nowrap bg-white text-center">
                <tr>
                    {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                    <td width="50">编号</td>
                    <td>头像</td>
                    <td>用户名</td>
                    <td>昵称</td>
                    <td>邮箱</td>
                    <td>角色</td>
                    <td width="80">管理员</td>
                    <td>创建时间</td>
                    <td>最后一次登录时间</td>
                    <td>最后一次登录IP</td>
                    <td width="120">操作</td>
                </tr>
                @if($lists->count())
                    @foreach($lists as $k=>$v)
                        <tr>
                            {{--<td width="30"><input type="checkbox" name="" id="" class="i-checks"></td>--}}
                            <td>{{ $v->id }}</td>
                            <td>
                                @empty(!$v->avatar)
                                <img src="{{ $v->avatar }}" alt="" width="30">
                                @else
                                    无
                                @endempty
                            </td>
                            <td>{{ $v->username }}</td>
                            <td>{{ $v->truename }}</td>
                            <td>{{ $v->email ?: '无' }}</td>
                            <td>
                                @if (count($v->role))
                                    @foreach ($v->roles as $vm)
                                        <span class="label label-primary">
                                        {{ $vm['name'] }}
                                    </span>&nbsp;
                                    @endforeach
                                @endif
                            </td>
                            <td>{!! colorText(is_superadmin(), '是', '否') !!}</td>
                            <td>{{ $v->created_at }}</td>
                            <td>{{ $v->lasttime ? $v->lasttime : '从未登录' }}</td>
                            <td>{{ $v->lastip ? $v->lastip : '从未登录' }}</td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.manager.edit', ['id' => $v->id]) }}">编辑</a>
                                <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.manager.destroy', $v->id) }}')">删除</button>
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
            </div>
            <a href="{{ route('admin.manager.create') }}" class="btn btn-info">添加管理员</a>
            <div class="text-center">
                @if($lists->count())
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

@endsection