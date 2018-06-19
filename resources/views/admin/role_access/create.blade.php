@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? editURL('role-access.update', $id) : route('role-access.store') }}" id="sform">
        {!! csrf_field() !!}
        {!! method_field(isset($id) ? 'PUT' : 'POST') !!}
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
                        <input id="name" type="text" class="form-control" name="name" value="{{ $name ?? old('name') }}">
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
                                        <input type="checkbox" class="i-checks" name="method[]"
                                               value="{{ $v }}" {{ (isset($method) && in_array($v, $method)) ? 'checked' : '' }}>{{ $v }}
                                    </label>
                                @endforeach
                            </div>
                            <span class="help-block m-b-none">留空表示所有请求类型</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                {{--</div>--}}
                {{--<div id="content_2">--}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">路由名称</label>
                        <div class="col-sm-10">

                            <input name="route" list="routelist" type="text" class="form-control" value="{{ $route ?? old('route') }}">
                            <datalist id="routelist">
                                @foreach($routeNames as $k => $v)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                @endforeach
                            </datalist>

                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                {{--</div>--}}

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存内容</button>
                        <a class="btn btn-white" href="javascript:history.go(-1);">返回</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(function() {
        //$('[name=mode]').change(function() {
        //    console.log($(this).val());
        //    if ($(this).val() === '1') {
        //        $('#content_1').show();
        //        $('#content_2').hide();
        //    } else {
        //        $('#content_2').show();
        //        $('#content_1').hide();
        //    }
        //});
    });
</script>
@endsection('content')