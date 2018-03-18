@extends('layout.admin')

@section('content')
<script src="{{ skin_path() }}js/plugins/laydate/laydate.js"></script>
<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? route('admin.gift.update') : route('admin.gift.create') }}" id="sform">
        {!! csrf_field() !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                @if(isset($id))
                    <h5>编辑奖品</h5>
                    <input type="hidden" name="id" value="{{ $id }}">
                @else
                    <h5>添加奖品</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">奖品名称</label>
                    <div class="col-sm-10">
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($name) ? $name : old('name') }}">
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">简介</label>
                    <div class="col-sm-10">
                        <input id="introduce" type="text" class="form-control" name="introduce" value="{{ isset($introduce) ? $introduce : old('introduce') }}"/>
                        <span class="help-block m-b-none">简单说明</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">缩略图</label>
                    <div class="col-sm-10">
                        <img src="{{ empty($thumb) ? old('thumb') : $thumb }}" id="pthumb" class="bg-warning" style="width: 150px; height: 150px;">
                        <input type="hidden" id="thumb" name="thumb" value="{{ empty($thumb) ? old('thumb') : $thumb }}">
                        <button class="btn btn-lg" type="button" onclick="Sthumb('thumb', 150, 150);" style="height: 150px; margin-bottom: 0;">上传</button>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">库存</label>
                    <div class="col-sm-10">
                        <label>
                            <input id="amount" type="number" class="form-control" name="amount" value="{{ isset($amount) ? $amount : old('amount') }}">
                        </label>
                        <span class="help-block m-b-none">库存为0时不予前台展示</span>
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
                        <a class="btn btn-white" href="{{ route('admin.gift.index') }}">返回</a>
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
        @if((isset($status) && $status))
        $('[name=status][value={{ $status }}]').attr('checked', true);
        @endif

        @if(old('status'))
        $('[name=status][value={{ $status }}]').attr('checked', true);
        @endif
    });
</script>
@endsection('content')