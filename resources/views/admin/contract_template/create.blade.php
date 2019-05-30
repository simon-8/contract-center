@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($contractTemplate->id) ? editURL('admin.contract-template.update', $contractTemplate->id) : route('admin.contract-template.store') }}" id="sform">
        {!! csrf_field() !!}
        {!! method_field(isset($contractTemplate->id) ? 'PUT' : 'POST') !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                @if(isset($contractTemplate->id))
                    <h5>编辑模板</h5>
                    <input type="hidden" name="id" value="{{ $contractTemplate->id }}">
                @else
                    <h5>添加模板</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">分类</label>
                    <div class="col-sm-10">
                        <select name="catid" class="form-control inline" style="width: 180px;">
                            <option value="">请选择分类</option>
                            @foreach((new \App\Models\ContractTemplate())->getCats(true) as $catid => $catname)
                                <option value="{{ $catid }}"
                                        @if (isset($data['catid']) && $data['catid'] === $catid) selected @endif>{{ $catname }}
                                </option>
                            @endforeach
                        </select>
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">类型</label>
                    <div class="col-sm-10">
                        <select name="typeid" class="form-control inline" style="width: 180px;">
                            <option value="">请选择类型</option>
                            @foreach((new \App\Models\ContractTemplate())->getTypes(true) as $typeid => $typename)
                                <option value="{{ $typeid }}"
                                        @if (isset($contractTemplate->typeid) && $contractTemplate->typeid === $typeid) selected @endif>{{ $typename }}
                                </option>
                            @endforeach
                        </select>
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">模板内容</label>
                    <div class="col-sm-10">
{{--                        {!! seditor($content ?? old('content')) !!}--}}
                        <textarea name="content" cols="30" rows="10" class="form-control">{{ $contractTemplate->content ?? old('content') }}</textarea>
                        <span class="help-block m-b-none"></span>
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
{{--        <div class="col-sm-12 col-md-6">--}}
{{--            <div class="ibox-title">--}}
{{--                <h5>其他设置</h5>--}}
{{--            </div>--}}
{{--            <div class="ibox-content">--}}
{{--                <div class="form-group">--}}
{{--                    <label class="col-sm-2 control-label">头像设置</label>--}}
{{--                    <div class="col-sm-10">--}}
{{--                        <img src="{{ imgurl($contractTemplate->avatar ?? old('avatar')) }}" id="pavatar" class="bg-warning" style="width: 100px; height: 100px;">--}}
{{--                        <input type="hidden" id="avatar" name="avatar" value="{{ $contractTemplate->avatar ?? old('avatar') }}">--}}
{{--                        <button class="btn btn-lg" type="button" onclick="Sthumb('avatar', 100, 100);" style="height: 100px; margin-bottom: 0;">上传</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="hr-line-dashed"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </form>
</div>

<!-- jQuery Validation plugin javascript-->
{{--{!! jquery_validate_js() !!}--}}
@endsection