<script src="{{ skin_path() }}lib/laydate/laydate.js"></script>
@extends('layout.admin')
@section('navbar')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i>
        首页 <span class="c-gray en">&gt;</span>
        系统设置 <span class="c-gray en">&gt;</span>
        操作日志
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
@endsection

@section('content')
    {{--<div>--}}
        {{--<form action="{{ route('user.index') }}" method="get">--}}
            {{--<input type="text" name="minDate" id="minDate" class="input-text" style="width:120px;" placeholder="开始时间" value="{{ $data['minDate']??'' }}">--}}
            {{--<input type="text" name="maxDate" id="maxDate" class="input-text" style="width:120px;" placeholder="结束时间" value="{{ $data['maxDate']??'' }}">--}}
            {{--<input type="text" name="keyword" id="keyword" class="input-text" style="width:150px;" placeholder="搜索词" value="{{ $data['keyword']??'' }}">--}}
            {{--<span class="select-box inline radius">--}}
                {{--<select name="type" class="select">--}}
                    {{--<option value="UserID" @if (isset($data['type']) && $data['type'] === 'UserID') selected @endif>玩家ID</option>--}}
                    {{--<option value="NickName" @if (isset($data['type']) && $data['type'] === 'NickName') selected @endif>昵称</option>--}}
                    {{--<option value="Mobile" @if (isset($data['type']) && $data['type'] === 'Mobile') selected @endif>手机号</option>--}}
                {{--</select>--}}
            {{--</span>--}}
            {{--<button class="btn btn-success radius" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>--}}
        {{--</form>--}}
    {{--</div>--}}
    {{--<script>--}}
        {{--var minDate = laydate.render({--}}
            {{--elem: '#minDate',--}}
            {{--//format: 'yyyy年MM月dd日',--}}
            {{--max: '{{ date('Y-m-d') }}',--}}
        {{--});--}}
        {{--var maxDate = laydate.render({--}}
            {{--elem: '#maxDate',--}}
            {{--//format: 'yyyy年MM月dd日',--}}
            {{--max: '{{ date('Y-m-d') }}',--}}
        {{--});--}}
    {{--</script>--}}
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="r">当前页共有数据：<strong>{{ $lists->count() }}</strong> 条</span>
    </div>
    <div class="table-responsive">
        <table class="table table-border table-bordered table-bg table-hover text-nowrap">
            <thead>
            <tr>
                <th scope="col" colspan="11">操作日志</th>
            </tr>
            <tr class="text-c">
                <th width="50">编号ID</th>
                <th>用户ID</th>
                <th>管理员名称</th>
                <th>事件名称</th>
                <th>事件信息</th>
                <th>操作IP</th>
                <th>操作时间</th>
            </tr>
            </thead>
            <tbody>
            @if(count($lists))
                @foreach($lists as $k=>$v)
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
                    <td colspan="7" class="text-c">
                        暂无数据
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="text-center">
        @if(count($lists))
            {!! $lists->render() !!}
        @endif
    </div>
@endsection