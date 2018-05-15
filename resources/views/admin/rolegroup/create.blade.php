@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? route('admin.rolegroup.update') : route('admin.rolegroup.create') }}" id="sform">
        {!! csrf_field() !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                @if(isset($id))
                    <h5>编辑会员组</h5>
                    <input type="hidden" name="id" value="{{ $id }}">
                @else
                    <h5>添加会员组</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">会员组名</label>
                    <div class="col-sm-10">
                        <input id="name" type="text" class="form-control" name="name" value="{{ isset($name) ? $name : old('name') }}">
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">拥有权限</label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="i-checks" name="access[]" value="1" {{ (isset($access) && $access) ? 'checked' : '' }}>是
                            </label>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">状态</label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="i-checks" name="status" value="0" {{ (isset($status) && !$status) ? 'checked' : '' }}>禁用
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
                        <a class="btn btn-white" href="{{ route('admin.rolegroup.index') }}">返回</a>
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
                    {{--<label class="col-sm-2 control-label">头像设置</label>--}}
                    {{--<div class="col-sm-10">--}}
                        {{--<img src="{{ imgurl(isset($avatar) ? $avatar : old('avatar')) }}" id="pavatar" class="bg-warning" style="width: 100px; height: 100px;">--}}
                        {{--<input type="hidden" id="avatar" name="avatar" value="{{ empty($avatar) ? old('avatar') : $avatar }}">--}}
                        {{--<button class="btn btn-lg" type="button" onclick="Sthumb('avatar', 100, 100);" style="height: 100px; margin-bottom: 0;">上传</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
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