@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? route('admin.roleaccess.update') : route('admin.roleaccess.create') }}" id="sform">
        {!! csrf_field() !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                @if(isset($id))
                    <h5>编辑权限</h5>
                    <input type="hidden" name="id" value="{{ $id }}">
                @else
                    <h5>添加权限</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">权限名称</label>
                    <div class="col-sm-10">
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($name) ? $name : old('name') }}">
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">请求路径</label>
                    <div class="col-sm-10">
                        <input id="path" type="text" class="form-control" name="path" value="{{ isset($path) ? $path : old('path') }}">
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group role-div">
                    <label class="col-sm-2 control-label">请求类型</label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            @foreach($allowMethods as $v)
                                <label>
                                    <input type="checkbox" class="i-checks" name="method[]" value="{{ $v }}" {{ (isset($method) && in_array($v, $method)) ? 'checked' : '' }}>{{ $v }}
                                </label>
                            @endforeach
                        </div>
                        <span class="help-block m-b-none">留空表示所有请求类型</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存内容</button>
                        <a class="btn btn-white" href="{{ route('admin.roleaccess.index') }}">返回</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                <h5>其他设置</h5>
            </div>
            <div class="ibox-content">
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 control-label">头像设置</label>--}}
                    {{--<div class="col-sm-10">--}}
                        {{--<img src="{{ imgurl(isset($avatar) ? $avatar : old('avatar')) }}" id="pavatar" class="bg-warning" style="width: 100px; height: 100px;">--}}
                        {{--<input type="hidden" id="avatar" name="avatar" value="{{ empty($avatar) ? old('avatar') : $avatar }}">--}}
                        {{--<button class="btn btn-lg" type="button" onclick="Sthumb('avatar', 100, 100);" style="height: 100px; margin-bottom: 0;">上传</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="hr-line-dashed"></div>--}}
            </div>
        </div>
    </form>
</div>

@endsection('content')