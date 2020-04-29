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
                        <td style="width: 60px;">管理员昵称</td>
                        <td style="width: 60px;">管理员姓名</td>
                        <td style="width: 60px;">免费签名</td>
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
                                <td class="name">{{ $v->name }}</td>
                                <td>{{ $v->organ_code ?: '/' }}</td>
                                <td>{{ $v->reg_type_text ?: '/' }}</td>
                                <td>{{ $v->legal_name ?: '-' }}</td>
                                <td>{{ $v->legal_idno ?: '-' }}</td>
                                <td>{{ $v->mobile ?: '-' }}</td>
                                <td>{{ $v->address ?: '-' }}</td>
                                <td>{{ $v->user->nickname ?: '-' }}</td>
                                <td>{{ $v->user->truename ?: '-' }}</td>
                                <td>{{ $v->sign_free ?: '-' }}</td>
                                <td>
                                    <span class="label label-success">{{ $v->status_text  }}</span>
                                </td>
{{--                                <td>{{ $v->created_at }}</td>--}}
                                <td>{{ $v->updated_at }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary sign-free-update" data-company='@json($v)'  data-href="{{ route('admin.company.signFreeUpdate', ['id' => $v->id]) }}">免签次数</a>
                                    <a class="btn btn-sm btn-primary category" data-page="category" data-href="{{ route('admin.contract-category.index', ['company_id' => $v->id]) }}">合同模板</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" rowspan="4">
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

    <div class="modal inmodal" id="signFreeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <form action="" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
{{--                    <input type="hidden" name="id" value="">--}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">修改免费签名次数</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">免费次数</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="sign_free" value="" placeholder="">
                                <span class="help-block m-b-none">请填写大于0的正整数</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">确定</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    let created_at = laydate.render({
        elem: '#created_at',
        max: '{{ date('Y-m-d') }}',
        range: true,
    });
</script>
<script>
    let signFreeModal = '#signFreeModal';
    $('.sign-free-update').click(function() {
        let href = $(this).attr('data-href');
        let company = $(this).attr('data-company');
        let json = JSON.parse(company);
        $(signFreeModal).find('form').attr('action', href);
        $(signFreeModal).find('[name=sign_free]').val(json.sign_free);
        $(signFreeModal).modal('show');
    });

    $('.category').click(function () {
        let href = $(this).data('href'),
            page = $(this).data('page'),
            name = $(this).text();
        name = $(this).closest('tr').find('.name').text() + name;
        openFrame($(this), href, page, name);
    });
</script>
@endsection
