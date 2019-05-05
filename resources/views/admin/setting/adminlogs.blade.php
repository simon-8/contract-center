@extends('layout.admin')

@section('content')
    <div class="col-sm-12 animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h5>操作日志</h5>
            </div>
            <div class="ibox-content">
                <table class="table table-bordered table-hover bg-white text-center">
                    <thead>
                        <tr>
                            <td>编号ID</td>
                            <td>用户ID</td>
                            <td>管理员名称</td>
                            <td>事件名称</td>
                            <td>事件信息</td>
                            <td>操作IP</td>
                            <td>操作时间</td>
                        </tr>
                    </thead>
                    @if(count($lists) > 0)
                        @foreach($lists as $v)
                            <tr class="text-c">
                                <td>{{ $v->id }}</td>
                                <td>{{ $v->userid }}</td>
                                <td>{{ $v->manager->username }}</td>
                                <td>{{ $v->event }}</td>
                                <td>{{ $v->data }}</td>
                                <td>{{ $v->ip }}</td>
                                <td>{{ $v->created_at }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">
                                未找到数据
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="text-center">
                @if(count($lists))
                    {!! $lists->render() !!}
                @endif
            </div>
        </div>
    </div>
@endsection('content')