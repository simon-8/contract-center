{{--@inject('authService', 'App\Services\AuthService')--}}

@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>公司列表</h5>
        </div>
        <div class="ibox-content">
            <div class="m-b-md">
                <form action="{{ route(request()->route()->getName()) }}" method="get" class="form-inline" id="searchForm">
                    <div class="input-group m-b">
                        <span class="input-group-addon">更新时间</span>
                        <input type="text" name="created_at" id="created_at" class="form-control" autocomplete="off"
                               placeholder="点击选择" value="{{ $data['created_at']??'' }}">
                    </div>

                    <div class="input-group m-b">
                        <select name="catid" class="form-control inline">
                            <option value="">请选择分类</option>
                            @foreach(\App\Models\ContractCategory::getCats() as $catid => $catname)
                            <option value="{{ $catid }}"
                                @if (isset($data['catid']) && $data['catid'] === (string) $catid) selected @endif>{{ $catname }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group m-b">
                        <select name="status" class="form-control inline">
                            <option value="">请选择状态</option>
                            @foreach((new \App\Models\Company())->getStatus() as $status => $statusText)
                                <option value="{{ $status }}"
                                        @if (isset($data['status']) && $data['status'] === (string) $status) selected @endif>{{ $statusText }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group m-b">
                        <select name="type" class="form-control inline" style="width:120px;">
{{--                            <option value="username"--}}
{{--                                    @if (isset($data['type']) && $data['type'] === 'username') selected @endif>用户名--}}
{{--                            </option>--}}
                            <option value="legal_name"
                                    @if (isset($data['type']) && $data['type'] === 'legal_name') selected @endif>法人
                            </option>
                            <option value="mobile"
                                    @if (isset($data['type']) && $data['type'] === 'mobile') selected @endif>手机号
                            </option>
                        </select>
                        <input type="text" name="keyword" id="keyword" class="form-control" autocomplete="off"
                               style="width:180px;" placeholder="请输入关键词" value="{{ $data['keyword']??'' }}">
                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>

                </form>
{{--                <a href="{{ route('admin.contract.create') }}" class="btn btn-primary">--}}
{{--                    <i class="fa fa-plus"></i>&nbsp;新增--}}
{{--                </a>--}}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover bg-white text-center text-nowrap">
                    <thead>
                    <tr class="text-center">
                        <td style="width: 50px;">编号</td>
                        <td style="width: 60px;">组织名称</td>
                        <td style="width: 60px;">机构代码</td>
                        <td style="width: 100px;">机构类型</td>
                        <td style="width: 100px;">法人</td>
                        <td style="width: 100px;">法人身份证</td>
                        <td style="width: 60px;">联系手机</td>
                        <td style="width: 60px;">注册地址</td>
                        <td style="width: 60px;">状态</td>
{{--                        <td style="width: 100px;">创建时间</td>--}}
                        <td style="width: 100px;">更新时间</td>
                        <td style="width: 180px;">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if($lists->count())
                        @foreach($lists as $v)
                            <tr>
                                <td>{{ $v->id }}</td>
                                <td>{{ $v->name }}</td>
                                <td>{{ $v->organ_code ?: '/' }}</td>
                                <td>{{ $v->reg_type ?: '/' }}</td>
                                <td>{{ $v->legal_name ?: '-' }}</td>
                                <td>{{ $v->legal_idno ?: '-' }}</td>
                                <td>{{ $v->mobile ?: '-' }}</td>
                                <td>{{ $v->address ?: '-' }}</td>
                                <td>
                                    <span class="label label-success">{{ $v->status_text  }}</span>
                                </td>
{{--                                <td>{{ $v->created_at }}</td>--}}
                                <td>{{ $v->updated_at }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary contract-show" data-href="{{ route('admin.contract.show', ['id' => $v->id]) }}">查看</a>
                                    <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.contract.destroy', $v->id) }}')">删除</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13" rowspan="4">
                                未找到数据
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                @if($lists->count())
                    {!! $lists->render() !!}
                @endif
            </div>
        </div>
    </div>

    {{--delete--}}
    @include('admin.modal.delete')

</div>
<script>
    let created_at = laydate.render({
        elem: '#created_at',
        max: '{{ date('Y-m-d') }}',
        range: true,
    });
</script>
@endsection
