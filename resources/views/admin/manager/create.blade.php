@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? route('admin.manager.update') : route('admin.manager.create') }}" id="sform">
        {!! csrf_field() !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                @if(isset($id))
                    <h5>编辑用户</h5>
                    <input type="hidden" name="id" value="{{ $id }}">
                @else
                    <h5>添加用户</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input id="username" type="text" class="form-control" name="username" value="{{ isset($username) ? $username : old('username') }}">
                        <span class="help-block m-b-none">用户用来登录的账户名称</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-10">
                        <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
                        <span class="help-block m-b-none">仅支持数字和字母的组合</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">真实姓名</label>
                    <div class="col-sm-10">
                        <input id="truename" type="text" class="form-control" name="truename" value="{{ isset($truename) ? $truename : old('truename') }}">
                        <span class="help-block m-b-none">用于登录后显示的昵称</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input id="email" type="text" class="form-control" name="email" value="{{ isset($email) ? $email : old('email') }}">
                        <span class="help-block m-b-none">便于邮件推送系统消息</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">管理员</label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="i-checks" name="is_admin" value="1" {{ (isset($is_admin) && $is_admin) ? 'checked' : '' }}>是
                            </label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @if(isset($is_admin) && $is_admin)
                    <div class="form-group role-div" style="display: none;">
                @else
                    <div class="form-group role-div">
                @endif
                    <label class="col-sm-2 control-label">权限管理</label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            @foreach((new \App\Repositories\MenuRepository())->getTopMenus() as $menu)
                            <label>
                                <input type="checkbox" class="i-checks" name="role[]" value="{{ $menu['id'] }}" {{ (isset($role) && in_array($menu['id'], $role)) ? 'checked' : '' }}>{{ $menu['name'] }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if(isset($is_admin) && $is_admin)
                    <div class="hr-line-dashed role-div" style="display: none;"></div>
                @else
                    <div class="hr-line-dashed role-div"></div>
                @endif

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存内容</button>
                        <a class="btn btn-white" href="{{ route('admin.manager.index') }}">返回</a>
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

<!-- jQuery Validation plugin javascript-->
{!! jquery_validate_js() !!}
<script>

    $(function(){
        {!! jquery_validate_default() !!}
        @if(isset($id))
        $("#sform").validate({
            debug:false,
            rules:{
                username:{
                    required:true,
                    minlength:4,
                },
                email:{
                    required:true,
                    email:true,
                },
                truename:{
                    required:true,
                    minlength:2,
                },
            }
        });
        @else
        $("#sform").validate({
            debug:false,
            rules:{
                username:{
                    required:true,
                    minlength:4,
                },
                password:{
                    required:true,
                    minlength:4,
                },
                email:{
                    required:true,
                    email:true,
                },
                truename:{
                    required:true,
                    minlength:2,
                },
            }
        });
        @endif

        $('[name=is_admin]').on('ifChecked', function(event) {
            $(".role-div").hide(300);
        })
        $('[name=is_admin]').on('ifUnchecked', function(event) {
            $(".role-div").show(300);
        })
    });
</script>
@endsection('content')