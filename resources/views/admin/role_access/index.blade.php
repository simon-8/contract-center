@extends('layout.admin')
@section('content')
<div class="col-sm-6 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>权限管理</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-nowrap bg-white text-center">
                <tr>
                    <td width="50">编号</td>
                    <td width="150">权限名称</td>
                    <td>路由地址</td>
                </tr>
                @if($lists->count())
                    @foreach($lists as $v)
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            <td>{{ $v['name'] }}</td>
                            <td>{{ $v['route'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">
                            未找到权限
                        </td>
                    </tr>
                @endif
            </table>
            </div>
{{--        <a class="btn btn-success" href="{{ route('admin.role-access.create') }}">添加权限</a>--}}
            @if($lists->count())
                <div class="text-center">
                    {!! $lists->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>

{{--delete--}}
@include('admin.modal.delete')

@endsection