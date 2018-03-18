@extends('layout.admin')

@section('content')
<script src="{{ skin_path() }}js/plugins/laydate/laydate.js"></script>
<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? route('admin.activity.update') : route('admin.activity.create') }}" id="sform">
        {!! csrf_field() !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                @if(isset($id))
                    <h5>编辑活动</h5>
                    <input type="hidden" name="id" value="{{ $id }}">
                @else
                    <h5>添加活动</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">活动名称</label>
                    <div class="col-sm-10">
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($name) ? $name : old('name') }}">
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">开始时间</label>
                    <div class="col-sm-10">
                        <input id="start_time" type="text" class="form-control" name="start_time" value="{{ isset($start_time) ? $start_time : old('start_time') }}" placeholder="点击选择日期">
                        <span class="help-block m-b-none">未到开始时间的活动不显示</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">结束时间</label>
                    <div class="col-sm-10">
                        <input id="end_time" type="text" class="form-control" name="end_time" value="{{ isset($end_time) ? $end_time : old('end_time') }}" placeholder="点击选择日期">
                        <span class="help-block m-b-none">开奖时间</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">人数限制</label>
                    <div class="col-sm-10">
                        <input id="max_actor" type="number" class="form-control" name="max_actor" value="{{ isset($max_actor) ? $max_actor : old('max_actor') }}">
                        <span class="help-block m-b-none">限制每个活动参与的最多人数</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">状态</label>
                    <div class="col-sm-10">
                        <div class="i-checks radio">
                            <label>
                                <input type="radio" name="status" value="1">开启
                            </label>
                            <label>
                                <input type="radio" name="status" value="0" checked>关闭
                            </label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存内容</button>
                        <a class="btn btn-white" href="{{ route('admin.activity.index') }}">返回</a>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="col-sm-12 col-md-6">--}}
            {{--<div class="ibox-title">--}}
                {{--<h5>其他设置</h5>--}}
            {{--</div>--}}
            {{--<div class="ibox-content">--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 control-label">模块权限</label>--}}
                    {{--<div class="col-sm-10">--}}
                        {{--<input type="text" class="form-control" name="" value="">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="hr-line-dashed"></div>--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 control-label">功能细分</label>--}}
                    {{--<div class="col-sm-10">--}}
                        {{--<input type="password" class="form-control" name="" value="">--}}
                        {{--<span class="help-block m-b-none">仅支持数字和字母的组合</span>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="hr-line-dashed"></div>--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 control-label">权限管理</label>--}}
                    {{--<div class="col-sm-10">--}}
                        {{--<input type="password" class="form-control" name="" value="">--}}
                        {{--<span class="help-block m-b-none">仅支持数字和字母的组合</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group"></div>--}}
                {{--<div class="hr-line-dashed"></div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </form>
</div>

<script>
    $(function(){
        var startTime = laydate.render({
            elem: '#start_time',//指定元素
            type: 'datetime',
            done: function(value, date, endDate){
                // todo
            }
        });
        var endTime = laydate.render({
            elem: '#end_time',//指定元素
            type: 'datetime',
            done: function(value, date, endDate){
                // todo
            }
        });

        @if((isset($status) && $status))
            $('[name=status][value={{ $status }}]').attr('checked', true);
        @endif

        @if(old('status'))
            $('[name=status][value={{ $status }}]').attr('checked', true);
        @endif

        {{--@if(!empty($start_time))--}}
        {{--startTime.set({--}}
            {{--value: "{{ $start_time }}"--}}
        {{--});--}}
        {{--@endif--}}
        {{--@if(old('start_time'))--}}
            {{--startTime.set({--}}
                {{--value: "{{ old('start_time') }}"--}}
            {{--});--}}
        {{--@endif--}}

        {{--@if(!empty($end_time))--}}
        {{--endTime.set({--}}
            {{--value: "{{ $end_time }}"--}}
        {{--});--}}
        {{--@endif--}}
        {{--@if(old('end_time'))--}}
        {{--endTime.set({--}}
            {{--value: "{{ old('end_time') }}"--}}
        {{--});--}}
        {{--@endif--}}
    });
</script>
@endsection('content')