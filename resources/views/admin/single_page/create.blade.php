@extends('layout.admin')

@section('content')

    <div class="ibox float-e-margins">
        <form method="post" class="form-horizontal" action="{{ isset($id) ? editURL('single-page.update', $id) : route('single-page.store') }}" id="sform">
            {!! csrf_field() !!}
            {!! method_field(isset($id) ? 'PUT' : 'POST') !!}
            <div class="col-sm-12 col-md-8">
                <div class="ibox-title">
                    @if(isset($id))
                        <h5>编辑单页</h5>
                        <input type="hidden" name="id" value="{{ $id }}">
                    @else
                        <h5>添加单页</h5>
                    @endif
                </div>
                <div class="ibox-content">

                    <div class="form-group">
                        <label class="col-sm-1 control-label">单页标题</label>
                        <div class="col-sm-11">
                            <input id="name" type="text" class="form-control" name="title" value="{{ $title ?? old('title') }}">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label">内容</label>
                        <div class="col-sm-11">
                            {!! seditor($content ?? old('content')) !!}
                            <span class="help-block m-b-none">单页内容</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <a class="btn btn-white" href="javascript:history.go(-1);">返回</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="ibox-title">
                    <h5>其他设置</h5>
                </div>
                <div class="ibox-content">

                    {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label">分类</label>--}}
                        {{--<div class="col-sm-10">--}}
                            {{--<select name="catid" class="form-control">--}}
                                {{--@if(!empty($categorys))--}}
                                    {{--@foreach ($categorys as $category)--}}
                                        {{--<option value="{{ $category['id'] }}">{{ $category['name'] }}</option>--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="hr-line-dashed"></div>--}}

                    <div class="form-group hidden">
                        <label class="col-sm-2 control-label">缩略图</label>
                        <div class="col-sm-10">
                            <img src="{{ imgurl($thumb ?? old('thumb')) }}" id="pthumb" class="bg-warning" style="width: 250px; height: {{ calcHeight(640, 250, 340) }}px;">
                            <input type="hidden" id="thumb" name="thumb" value="{{ $thumb ?? old('thumb') }}">
                            <button class="btn btn-primary btn-lg" type="button" onclick="Sthumb('thumb', 640, 340);" style="height: {{ calcHeight(640, 250, 340) }}px; margin-bottom: 0;">上传</button>
                            <button class="btn btn-danger btn-lg" type="button" onclick="document.getElementById('thumb').value = '';document.getElementById('pthumb').setAttribute('src','');" style="height: {{ calcHeight(640, 250, 340) }}px; margin-bottom: 0;">删除</button>
                        </div>
                    </div>
                    <div class="hr-line-dashed hidden"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <input type="checkbox" name="status" value="1" id="status" class="switch" data-on-text="正常" data-off-text="关闭"/>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                </div>
            </div>
        </form>
    </div>


    <script>
        $(function(){
            $('[name="status"]').bootstrapSwitch('state', {{ $status??'true' }}); // true || false
        });
    </script>
@endsection('content')