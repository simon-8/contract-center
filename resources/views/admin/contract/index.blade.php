{{--@inject('authService', 'App\Services\AuthService')--}}

@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>合同列表</h5>
        </div>
        <div class="ibox-content">
            <div class="m-b-md">
                <form action="{{ route(request()->route()->getName()) }}" method="get" class="form-inline" id="searchForm">
                    <div class="input-group m-b">
                        <span class="input-group-addon">添加时间</span>
                        <input type="text" name="created_at" id="created_at" class="form-control" autocomplete="off"
                               placeholder="点击选择" value="{{ $data['created_at']??'' }}">
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
                        <select name="catid" class="form-control inline">
                            <option value="">参与人类型</option>
                            @foreach(\App\Models\Contract::getPlayers() as $typeid => $typename)
                                <option value="{{ $typeid }}"
                                        @if (isset($data['players']) && $data['players'] === (string) $typeid) selected @endif>{{ $typename }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group m-b">
                        <select name="status" class="form-control inline">
                            <option value="">请选择状态</option>
                            @foreach((new \App\Models\Contract())->getStatus() as $status => $statusText)
                                <option value="{{ $status }}"
                                        @if (isset($data['status']) && $data['status'] === (string) $status) selected @endif>{{ $statusText }}
                                </option>
                            @endforeach
                        </select>
                    </div>
{{--                    <div class="input-group m-b">--}}
{{--                        <input type="text" name="content" id="content" class="form-control" autocomplete="off"--}}
{{--                               style="width:180px;" placeholder="请输入关键词" value="{{ $data['content']??'' }}">--}}
{{--                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> 搜索</button>--}}
{{--                    </div>--}}
                    <div class="input-group m-b">
                        <select name="type" class="form-control inline" style="width:120px;">
{{--                            <option value="username"--}}
{{--                                    @if (isset($data['type']) && $data['type'] === 'username') selected @endif>用户名--}}
{{--                            </option>--}}
                            <option value="nickname"
                                    @if (isset($data['type']) && $data['type'] === 'nickname') selected @endif>昵称
                            </option>
                            <option value="mobile"
                                    @if (isset($data['type']) && $data['type'] === 'mobile') selected @endif>手机号
                            </option>
                        </select>
                        <input type="text" name="keyword" id="keyword" class="form-control" autocomplete="off"
                               style="width:180px;" placeholder="请输入关键词" value="{{ $data['keyword']??'' }}">
                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                    <div>
                        <div class="input-group m-b">
                            <span class="input-group-addon">甲方</span>
                            <input type="text" name="jiafang" id="jiafang" class="form-control" autocomplete="off" value="{{ $data['jiafang']??'' }}" style="width:100px;">
                        </div>
                        <div class="input-group m-b">
                            <span class="input-group-addon">乙方</span>
                            <input type="text" name="yifang" id="yifang" class="form-control" autocomplete="off" value="{{ $data['yifang']??'' }}" style="width:100px;">
                        </div>
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
                        <td style="width: 60px;">分类</td>
                        <td style="width: 60px;">名称</td>
                        <td style="width: 100px;">甲方</td>
                        <td style="width: 100px;">乙方</td>
                        <td style="width: 100px;">居间人</td>
                        <td style="width: 60px;">甲确认</td>
                        <td style="width: 60px;">乙确认</td>
                        <td style="width: 60px;">甲签名</td>
                        <td style="width: 60px;">乙签名</td>
                        <td style="width: 60px;">状态</td>
                        <td style="width: 100px;">创建时间</td>
                        <td style="width: 100px;">更新时间</td>
                        <td style="width: 100px;">确认时间</td>
                        <td style="width: 180px;">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if($lists->count())
                        @foreach($lists as $v)
                            <tr>
                                <td>{{ $v->id }}</td>
{{--                                <td>{{ $v->listorder }}</td>--}}
                                <td>
                                    <span class="label label-default">
                                        {{ $v->getCatText() }}
                                    </span>&nbsp;
                                    <span class="label label-default">{{ $v->getPlayersText() }}</span>
                                </td>
                                </td>
                                <td>{{ $v->name }}</td>
                                <td>{{ $v->jiafang ?: '/' }}</td>
                                <td>{{ $v->yifang ?: '/' }}</td>
                                <td>{{ $v->jujianren ?: '/' }}</td>
                                <td>{!! colorText($v->confirm_first, '是', '否') !!}</td>
                                <td>{!! colorText($v->confirm_second, '是', '否') !!}</td>
                                <td>{!! colorText($v->signed_first, '是', '否') !!}</td>
                                <td>{!! colorText($v->signed_second, '是', '否') !!}</td>
                                <td>
                                    <span class="label label-success">{{ $v->getStatusText()  }}</span>
                                </td>
                                <td>{{ $v->created_at }}</td>
                                <td>{{ $v->updated_at }}</td>
                                <td>{{ $v->confirm_at }}</td>
                                <td>
                                    @if($v->path_pdf)
                                    <a class="btn btn-sm btn-white" href="{{ resourceUrl($v->path_pdf) }}" target="_blank">PDF</a>
                                    @endif
                                    <a class="btn btn-sm btn-primary contract-show" data-href="{{ route('admin.contract.show', ['id' => $v->id]) }}">查看</a>
{{--                                    <a class="btn btn-sm btn-info" href="{{ route('admin.contract.edit', ['id' => $v->id]) }}">编辑</a>--}}
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
        //done: function(value, date, endDate){
        //    console.log(value, date, endDate);
        //    if (value) {
        //        let date = value.split(' - ');
        //        if (date[0] > date[1]) {
        //            layer.alert('结束时间不得小于开始时间');
        //            return false;
        //        }
        //        searchForm.find('[name=minDate]').val(date[0]);
        //        searchForm.find('[name=maxDate]').val(date[1]);
        //    } else {
        //        searchForm.find('[name=minDate]').val('');
        //        searchForm.find('[name=maxDate]').val('');
        //    }
        //}
    });

    $('.contract-show').click(function () {
        layer.open({
            type: 2,
            title: '合同预览',
            shadeClose: true,
            content: $(this).data('href'),
            area: ['65%', '80%']
        });
    });
</script>
@endsection
