@extends('layout.admin')

@section('content')
<style>
    .checkbox .col-sm-3 {
        padding-left: 0;
    }
</style>
<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($id) ? editURL('roles.update', $id) : route('roles.store') }}" id="sform">
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
                        <div class="checkbox">
                            @foreach ($accessLists as $v)
                            <div class="col-sm-3">
                                <label>
                                    <input type="checkbox" class="i-checks" name="access[]" value="{{ $v['id'] }}" {{ (isset($access) && in_array($v['id'], $access)) ? 'checked' : '' }}>{{ $v['name'] }}
                                </label>
                            </div>
                            @endforeach
                        </div>
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

        //$('[name=is_admin]').on('ifChecked', function(event) {
        //    $(".role-div").hide(300);
        //})
        //$('[name=is_admin]').on('ifUnchecked', function(event) {
        //    $(".role-div").show(300);
        //})
    });
</script>
@endsection('content')