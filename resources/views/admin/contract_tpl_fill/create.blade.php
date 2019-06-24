@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($contractTplFill->id) ? editURL('admin.contract-tpl-fill.update', $contractTplFill->id) : route('admin.contract-tpl-fill.store') }}" id="sform">
        {!! csrf_field() !!}
        {!! method_field(isset($contractTplFill->id) ? 'PUT' : 'POST') !!}
        <div class="col-sm-12 col-md-6">
            <div class="ibox-title">
                @if(isset($contractTplFill->id))
                    <h5>编辑模板</h5>
                    <input type="hidden" name="id" value="{{ $contractTplFill->id }}">
                @else
                    <h5>添加模板</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">合同类型</label>
                    <div class="col-sm-10">
                        <select name="catid" class="form-control inline" style="width: 180px;">
{{--                            <option value="">请选择合同类型</option>--}}
                            @foreach(\App\Services\ContractService::getCats() as $catid => $catname)
                                <option value="{{ $catid }}"
                                        @if (isset($contractTplFill->catid) && $contractTplFill->catid === $catid) selected @endif>{{ $catname }}
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
                        <textarea name="content" cols="30" rows="10" class="form-control">{{ $contractTplFill->content ?? old('content') }}</textarea>
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
    </form>
</div>
@endsection