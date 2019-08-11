@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">

    <form method="post" class="form-horizontal" action="{{ isset($contractTpl->id) ? editURL('admin.contract-tpl.update', $contractTpl->id) : route('admin.contract-tpl.store') }}" id="sform">
        {!! csrf_field() !!}
        {!! method_field(isset($contractTpl->id) ? 'PUT' : 'POST') !!}
        <div class="col-sm-12">
            <div class="ibox-title">
                @if(isset($contractTpl->id))
                    <h5>编辑模板</h5>
                    <input type="hidden" name="id" value="{{ $contractTpl->id }}">
                @else
                    <h5>添加模板</h5>
                @endif
            </div>
            <div class="ibox-content">

                <div class="form-group">
                    <label class="col-sm-2 control-label">所属模块</label>
                    <div class="col-sm-10">
                        <select name="section_id" class="form-control inline" style="width: 180px;">
{{--                            <option value="">请选择合同类型</option>--}}
                            @foreach((new \App\Models\ContractTplSection())->get()->pluck('name', 'id') as $section_id => $section_name)
                                <option value="{{ $section_id }}"
                                        @if (isset($contractTpl->section_id) && $contractTpl->section_id === $section_id) selected @endif>{{ $section_name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="help-block m-b-none"></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

{{--                <div class="form-group">--}}
{{--                    <label class="col-sm-2 control-label">参与者类型</label>--}}
{{--                    <div class="col-sm-10">--}}
{{--                        <select name="typeid" class="form-control inline" style="width: 180px;">--}}
{{--                            @foreach((new \App\Models\Contract())->getPlayers() as $typeid => $typename)--}}
{{--                                <option value="{{ $typeid }}"--}}
{{--                                        @if (isset($contractTpl->players) && $contractTpl->players === $typeid) selected @endif>{{ $typename }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <span class="help-block m-b-none"></span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="hr-line-dashed"></div>--}}

                <div class="form-group">
                    <label class="col-sm-2 control-label">模板内容</label>
                    <div class="col-sm-10">
                        {!! contractTemplateEditor($contractTpl->content ?? old('content')) !!}
{{--                        <textarea name="content" cols="30" rows="10" class="form-control">{{ $contractTpl->content ?? old('content') }}</textarea>--}}
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
