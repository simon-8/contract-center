@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>律师见证</h5>
        </div>
        <div class="ibox-content">
            <div class="m-b-md">
                <form action="{{ route(request()->route()->getName()) }}" method="get" class="form-inline" id="searchForm">
                    <div class="input-group m-b">
                        <span class="input-group-addon">更新时间</span>
                        <input type="text" name="updated_at" id="updated_at" class="form-control" autocomplete="off"
                               placeholder="点击选择" value="{{ $data['updated_at']??'' }}">
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
                        <select name="players" class="form-control inline">
                            <option value="">参与人类型</option>
                            @foreach(App\Models\Contract::getPlayers() as $key => $val)
                                <option value="{{ $key }}"
                                        @if (isset($data['players']) && $data['players'] === (string) $key) selected @endif>{{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group m-b">
                        <select name="status" class="form-control inline">
                            <option value="">请选择状态</option>
                            @foreach((new \App\Models\OrderLawyerConfirm())->getStatus() as $status => $statusText)
                                <option value="{{ $status }}"
                                        @if (isset($data['status']) && $data['status'] === (string) $status) selected @endif>{{ $statusText }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group m-b">
                        <select name="type" class="form-control inline" style="width:120px;">
{{--                            <option value="orderid"--}}
{{--                                    @if (isset($data['type']) && $data['type'] === 'orderid') selected @endif>订单ID--}}
{{--                            </option>--}}
                            <option value="name"
                                    @if (isset($data['type']) && $data['type'] === 'name') selected @endif>合同名称
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
                        <td style="width: 60px;">合同名称</td>
                        <td style="width: 60px;">用户昵称</td>
{{--                        <td style="width: 100px;">订单价格</td>--}}
{{--                        <td style="width: 100px;">订单ID</td>--}}
{{--                        <td style="width: 100px;">第三方ID</td>--}}
{{--                        <td style="width: 60px;">充值渠道</td>--}}
{{--                        <td style="width: 60px;">充值方式</td>--}}
                        <td style="width: 60px;">备注</td>
                        <td style="width: 60px;">地址</td>
                        <td style="width: 60px;">状态</td>
                        <td style="width: 100px;">申请时间</td>
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
                                <td>
                                    <a href="javascript:void;" title="点击查看合同信息" class="show-contract" data-href="{{ editURL('admin.contract.show', $v->userid) }}">{{ $v->contract->name }}</a>
                                </td>
                                <td>
                                    <a href="javascript:void;" title="点击查看用户信息" class="show-user" data-href="{{ editURL('admin.user.show', $v->userid) }}">{{ $v->user->nickname }}</a>
                                </td>
{{--                                <td>{{ $v->amount }}</td>--}}
{{--                                <td>{{ $v->orderid }}</td>--}}
{{--                                <td>{{ $v->torderid }}</td>--}}
{{--                                <td>{{ $v->channel }}</td>--}}
{{--                                <td>{{ $v->gateway }}</td>--}}
                                <td>
                                    <a href="javascript:void;" class="show-remark" data-remark="{{ $v->remark }}">查看</a>
                                </td>
                                <td>
                                    <a href="javascript:void;" class="show-address" data-address='@json($v->address)' data-href="{{ editURL('admin.order-lawyer-confirm.update', $v['id']) }}">查看</a>
                                </td>
                                <td>
                                    @if ($v->status == \App\Models\OrderLawyerConfirm::STATUS_APPLY)
                                        <span class="label lable-xs label-default radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\OrderLawyerConfirm::STATUS_HAS_BEEN_SEND)
                                        <span class="label lable-xs label-primary radius">{{ $v->getStatusText() }}</span>
                                    @endif
                                </td>
{{--                                <td>{{ $v->payed_at }}</td>--}}
                                <td>{{ $v->created_at }}</td>
                                <td>{{ $v->updated_at }}</td>

                                <td>
                                    @if ($v->status == \App\Models\OrderLawyerConfirm::STATUS_APPLY)
                                    <a class="btn btn-sm btn-info show-control" data-express='@json($v->only(['express_name', 'express_no']))' data-href="{{ editURL('admin.order-lawyer-confirm.update', $v['id']) }}">发货</a>
                                    @endif
                                    @if ($v->status == \App\Models\OrderLawyerConfirm::STATUS_HAS_BEEN_SEND)
                                        <a class="btn btn-sm btn-info show-control" data-express='@json($v->only(['express_name', 'express_no']))' data-href="{{ editURL('admin.order-lawyer-confirm.update', $v['id']) }}">快递信息</a>
                                    @endif
{{--                                    <a class="btn btn-sm btn-info" href="{{ route('admin.contract.edit', ['id' => $v->id]) }}">编辑</a>--}}
{{--                                    <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.contract.destroy', $v->id) }}')">删除</button>--}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" rowspan="4">
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

    {{-- address --}}
    <div class="modal inmodal" id="addressModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <form action="" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">收货地址</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">省份</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="province" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">城市</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="city" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">地区</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="area" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">详细地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="address" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">联系人</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="linkman" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">联系手机</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="mobile" value="" readonly>
                            </div>
                        </div>
                    </div>
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>--}}
{{--                        <button type="submit" class="btn btn-primary">修改</button>--}}
{{--                    </div>--}}
                </form>
            </div>
        </div>
    </div>

    {{--update--}}
    <div class="modal inmodal" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <form action="" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">更新</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="status" value="{{ \App\Models\OrderLawyerConfirm::STATUS_HAS_BEEN_SEND }}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">快递名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="express_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">快递单号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="express_no" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">修改</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let addressModal = '#addressModal';
    let updateModal = '#updateModal';
    let updated_at = laydate.render({
        elem: '#updated_at',
        max: '{{ date('Y-m-d') }}',
        range: true,
    });
    $('.show-user').click(function() {
        let href = $(this).data('href');
        layer.open({
            type: 2,
            title: '用户信息',
            content: href,
            shadeClose: true,
            area: ['60%', '60%']
        });
    });
    $('.show-contract').click(function() {
        let href = $(this).data('href');
        layer.open({
            type: 2,
            title: '合同信息',
            content: href,
            shadeClose: true,
            area: ['80%', '60%']
        });
    });
    $('.show-remark').hover(function(){
        var that = this;
        layer.tips($(this).data('remark'), that); //在元素的事件回调体中，follow直接赋予this即可
    }, function () {
        layer.closeAll();
    });

    $('.show-address').click(function() {
        let address = $(this).attr('data-address');
        let href = $(this).attr('data-href');
        let json = JSON.parse(address);
        $.each(json , function(k , v){
            $(addressModal).find('[name=' + k + ']').val(v);
        });
        //$(addressModal).find('form').attr('action', href);
        $(addressModal).modal('show');
    });

    $('.show-control').click(function() {
        let express = $(this).attr('data-express');
        let href = $(this).attr('data-href');
        let json = JSON.parse(express);
        $.each(json , function(k , v){
            $(updateModal).find('[name=' + k + ']').val(v);
        });
        $(updateModal).find('form').attr('action', href);
        $(updateModal).modal('show');
    });

</script>
@endsection
