@extends('layout.admin')

@section('content')

<div class="ibox float-e-margins">
    <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="ibox-title">
            <h5>模板详情</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover bg-white text-center text-nowrap">
                    <tr>
                        <td class="col-sm-4">合同分类</td>
                        <td class="col-sm-8">
                            <span class="label label-primary">{{ $contract->getCatText() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-4">合同名</td>
                        <td class="col-sm-8">{{ $contract->name }}</td>
                    </tr>
                    @foreach ($fills as $fill)
                        <tr>
                            <td class="col-sm-4">
                                {{ $fill->content }}
                            </td>
                            <td class="col-sm-8">
                                {{ $contract->content->content['fills'][$fill->formname] ?? '/' }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td rowspan="{{ count($contract->content->content['rules']) + 1 }}">通用条件</td>
                    </tr>
                    @foreach ($rules as $rule)
                        @if (in_array($rule->id, $contract->content->content['rules']))
                        <tr>
                            <td>
                                {{ $rule->content }}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td class="col-sm-4">添加时间</td>
                        <td class="col-sm-8">{{ $contract->created_at }}</td>
                    </tr>
                    <tr>
                        <td class="col-sm-4">更新时间</td>
                        <td class="col-sm-8">{{ $contract->updated_at }}</td>
                    </tr>
                    <tr>
                        <td class="col-sm-4">确认时间</td>
                        <td class="col-sm-8">{{ $contract->confirm_at }}</td>
                    </tr>
                    <tr>
                        <td class="col-sm-4">甲方确认</td>
                        <td class="col-sm-8">
                            {!! colorText($contract->user_confirm, '是', '否') !!}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-4">乙方确认</td>
                        <td class="col-sm-8">
                            {!! colorText($contract->target_confirm, '是', '否') !!}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-4">状态</td>
                        <td class="col-sm-8">
                            <span class="label label-primary">{{ $contract->getStatusText() }}</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="">
                <a class="btn btn-warning" href="javascript:history.go(-1);">返回</a>
            </div>
        </div>
    </div>
</div>
@endsection