@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
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
                    <td>路由地址</td>
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
                            <td>{{ $v['route'] }}</td>
                            <td>
                                <a class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" href="{{ editURL('role-access.edit', $v['id']) }}">编辑</a>
                                <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('role-access.destroy', $v['id']) }}')">删除</button>
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
            <a class="btn btn-success" href="{{ route('role-access.create') }}">添加权限</a>
            @if(count($lists))
                <div class="text-center">
                    {!! $lists->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>

{{--delete--}}
@include('admin.modal.delete')

@endsection('content')