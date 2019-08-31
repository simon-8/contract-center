@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>订单列表</h5>
        </div>
        <div class="ibox-content">
            <div class="m-b-md">
                <form action="{{ route(request()->route()->getName()) }}" method="get" class="form-inline" id="searchForm">
                    <div class="input-group m-b">
                        <span class="input-group-addon">支付时间</span>
                        <input type="text" name="updated_at" id="updated_at" class="form-control" autocomplete="off"
                               placeholder="点击选择" value="{{ $data['updated_at']??'' }}">
                    </div>

                    <div class="input-group m-b">
                        <select name="catid" class="form-control inline">
                            <option value="">请选择分类</option>
                            @foreach((new \App\Models\ContractCategory())->getCats() as $catid => $catname)
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
                            @foreach((new \App\Models\Order())->getStatus() as $status => $statusText)
                                <option value="{{ $status }}"
                                        @if (isset($data['status']) && $data['status'] === (string) $status) selected @endif>{{ $statusText }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group m-b">
                        <select name="type" class="form-control inline" style="width:120px;">
                            <option value="orderid"
                                    @if (isset($data['type']) && $data['type'] === 'orderid') selected @endif>订单ID
                            </option>
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
                        <td style="width: 100px;">订单价格</td>
                        <td style="width: 100px;">订单ID</td>
{{--                        <td style="width: 100px;">第三方ID</td>--}}
                        <td style="width: 60px;">充值渠道</td>
                        <td style="width: 60px;">充值方式</td>
                        <td style="width: 60px;">备注</td>
                        <td style="width: 60px;">状态</td>
                        <td style="width: 100px;">支付时间</td>
{{--                        <td style="width: 100px;">创建时间</td>--}}
                        <td style="width: 100px;">更新时间</td>
{{--                        <td style="width: 180px;">操作</td>--}}
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
                                <td>{{ $v->amount }}</td>
                                <td>{{ $v->orderid }}</td>
{{--                                <td>{{ $v->torderid }}</td>--}}
                                <td>{{ $v->channel }}</td>
                                <td>{{ $v->gateway }}</td>
                                <td>
                                    <a href="javascript:void;" class="show-remark" data-remark="{{ $v->remark }}">查看</a>
                                </td>
                                <td>
                                    @if ($v->status == \App\Models\Order::STATUS_WAIT_PAY)
                                        <span class="label lable-xs label-default radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\Order::STATUS_ALREADY_PAY)
                                        <span class="label lable-xs label-primary radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\Order::STATUS_CONFIRM)
                                        <span class="label lable-xs label-primary radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\Order::STATUS_APPLY_REFUND)
                                        <span class="label lable-xs label-warning radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\Order::STATUS_REFUND_FAILD)
                                        <span class="label lable-xs label-danger radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\Order::STATUS_REFUND_SUCCESS)
                                        <span class="label lable-xs label-success radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\Order::STATUS_TRADE_SUCCESS)
                                        <span class="label lable-xs label-success radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\Order::STATUS_TRADE_CLOSE)
                                        <span class="label lable-xs label-default radius">{{ $v->getStatusText() }}</span>
                                    @elseif($v->status == \App\Models\Order::STATUS_TRADE_SELL_CLOSE)
                                        <span class="label lable-xs label-default radius">{{ $v->getStatusText() }}</span>
                                    @endif
                                </td>
                                <td>{{ $v->payed_at }}</td>
{{--                                <td>{{ $v->created_at }}</td>--}}
                                <td>{{ $v->updated_at }}</td>

{{--                                <td>--}}
{{--                                    <a class="btn btn-sm btn-default" href="{{ route('admin.contract.show', ['id' => $v->id]) }}">查看</a>--}}
{{--                                    <a class="btn btn-sm btn-info" href="{{ route('admin.contract.edit', ['id' => $v->id]) }}">编辑</a>--}}
{{--                                    <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.contract.destroy', $v->id) }}')">删除</button>--}}
{{--                                </td>--}}
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
</script>
@endsection
