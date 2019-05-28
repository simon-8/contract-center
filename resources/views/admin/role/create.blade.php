@extends('layout.admin')

@section('content')
<style>
    .checkbox .col-sm-3 {
        padding-left: 0;
    }
</style>
<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? editURL('admin.role.update', $id) : route('admin.role.store') }}" id="sform">
        {!! csrf_field() !!}
        {!! method_field(isset($id) ? 'PUT' : 'POST') !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                @if(isset($id))
                    <h5>编辑角色</h5>
                    <input type="hidden" name="id" value="{{ $id }}">
                @else
                    <h5>添加角色</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">角色名</label>
                    <div class="col-sm-10">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $name ?? old('name') }}">
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">拥有权限</label>
                    <div class="col-sm-10">
                        @foreach($accessLists as $route => $name)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="">
                                            {{ $name['name'] }}
                                        </a>
                                    </h5>
                                </div>
                                @if (!empty($name['child']))
                                    <div id="" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="checkbox">
                                                @foreach($name['child'] as $child)
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="checkbox" class="i-checks" name="access[]" value="{{ $child['id'] }}" {{ (isset($access) && in_array($child['id'], $access)) ? 'checked' : '' }}>{{ $child['name'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        {{--<div class="checkbox">--}}
                        {{--@foreach($accessLists as $route => $name)--}}
                            {{--<div class="col-sm-12">--}}
                                {{--<label>--}}
                                    {{--{{ $name['name'] }}--}}
                                {{--</label>--}}
                            {{--</div>--}}
                            {{--@foreach($name['child'] as $child)--}}
                            {{--<div class="col-sm-3">--}}
                                {{--<label>--}}
                                    {{--<input type="checkbox" class="i-checks" name="access[]" value="{{ $child['id'] }}" {{ (isset($access) && in_array($child['id'], $access)) ? 'checked' : '' }}>{{ $child['name'] }}--}}
                                {{--</label>--}}
                            {{--</div>--}}
                            {{--@endforeach--}}
                        {{--@endforeach--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">状态</label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="i-checks" name="status" value="0" {{ (!isset($status) || !$status) ? 'checked' : '' }}>禁用
                            </label>
                            <label>
                                <input type="radio" class="i-checks" name="status" value="1" {{ (isset($status) && $status) ? 'checked' : '' }}>开启
                            </label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存</button>
                        <a class="btn btn-white" href="javascript:history.go(-1);">返回</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection