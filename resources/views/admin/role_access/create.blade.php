@inject('authService', 'App\Services\AuthService')
@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? editURL('admin.role-access.update', $id) : route('admin.role-access.store') }}" id="sform">
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

                {{--<div id="content_2">--}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">路由名称</label>
                        <div class="col-sm-10">
                            <select name="route" class="form-control">
                                <option value="">请选择</option>
                                @foreach($authService->getRoutes() as $route => $name)
                                <option value="{{ $route }}" data="{{ $name }}">{{ $name }} - {{ $route }}</option>
                                @endforeach
                            </select>
                            {{--<input name="route" list="routelist" type="text" class="form-control" value="{{ $route ?? old('route') }}">--}}
                            {{--<datalist id="routelist">--}}
                                {{--@foreach($authService as $k => $v)--}}
                                    {{--<option value="{{ $k }}">{{ $k }}</option>--}}
                                {{--@endforeach--}}
                            {{--</datalist>--}}

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
        $("form [name='route']").change(function() {
            let txt = $(this).find("option:selected").attr('data');
            $(this).closest('form').find("[name='name']").val(txt);
        });
    });
</script>
@endsection