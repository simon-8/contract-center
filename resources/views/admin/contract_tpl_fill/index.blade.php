{{--@inject('authService', 'App\Services\AuthService')--}}

@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>合同模板管理</h5>
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
                            @foreach(\App\Services\ContractService::getCats() as $catid => $catname)
                            <option value="{{ $catid }}"
                                @if (isset($data['catid']) && $data['catid'] === $catid) selected @endif>{{ $catname }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group m-b">
                        <input type="text" name="content" id="content" class="form-control" autocomplete="off"
                               style="width:180px;" placeholder="请输入关键词" value="{{ $data['content']??'' }}">
                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </form>
                <a href="{{ route('admin.contract-tpl-fill.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>&nbsp;新增
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover bg-white text-center text-nowrap">
                    <thead>
                    <tr class="text-center">
                        <td style="width: 50px;">编号</td>
                        <td style="width: 50px;">排序</td>
                        <td style="width: 60px;">分类</td>
                        <td style="width: 60px;">表单名称</td>
                        <td style="width: 200px;">内容</td>
                        <td style="width: 100px;">创建时间</td>
                        <td style="width: 100px;">更新时间</td>
                        <td style="width: 180px;">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if($lists->count())
                        @foreach($lists as $v)
                            <tr>
                                <td>{{ $v->id }}</td>
                                <td>{{ $v->listorder }}</td>
                                <td>{{ \App\Services\ContractService::getCatText($v->catid) }}</td>
                                <td>{{ $v->formname }}</td>
                                <td>{{ \Str::limit($v->content, 30) }}</td>
                                <td>{{ $v->created_at }}</td>
                                <td>{{ $v->updated_at }}</td>
                                <td>
                                    @if ($v->id > 5)
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.contract-tpl-fill.edit', ['id' => $v->id]) }}">编辑</a>
                                    <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.contract-tpl-fill.destroy', $v->id) }}')">删除</button>
                                    @endif
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
</script>
@endsection