{{--@inject('authService', 'App\Services\AuthService')--}}

@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>用户管理</h5>
        </div>
        <div class="ibox-content">
            <div class="m-b-md">
                <form action="{{ route(request()->route()->getName()) }}" method="get" class="form-inline" id="searchForm">
                    <div class="input-group m-b"><span class="input-group-addon">注册时间</span>
                        <input type="text" name="created_at" id="created_at" class="form-control" autocomplete="off"
                               placeholder="点击选择" value="{{ $data['created_at']??'' }}">
                    </div>

                    <div class="input-group1 m-b">
                        <select name="type" class="form-control inline">
                            <option value="username"
                                    @if (isset($data['type']) && $data['type'] === 'username') selected @endif>用户名
                            </option>
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
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover bg-white text-center text-nowrap">
                    <thead>
                    <tr class="text-center">
                        <th width="50">编号</th>
                        <th width="150">用户名</th>
                        <th>昵称</th>
                        <th>手机号码</th>
                        <th>国家</th>
                        <th>省份</th>
                        <th>城市</th>
                        <th>头像</th>
                        <th>性别</th>
                        {{--<th>关注时间</th>--}}
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th width="180">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($lists->count())
                        @foreach($lists as $v)
                            <tr>
                                <td>{{ $v['id'] }}</td>
                                <td>{{ $v['username']?:'无' }}</td>
                                <td>{{ $v['nickname'] }}</td>
                                <td>{{ $v['mobile']?:'无' }}</td>
                                <td>{{ $v['city'] }}</td>
                                <td>{{ $v['province'] }}</td>
                                <td>{{ $v['country'] }}</td>
                                <td><img src="{{ $v['avatar'] }}" alt="" width="30"></td>
                                <td>{{ $v['gender'] ? ($v['gender'] == 1 ? '男' : '女') : '未知' }}</td>
                                {{--<td>{{ $v['subscribe_at'] }}</td>--}}
                                <td>{{ $v['created_at'] }}</td>
                                <td>{{ $v['updated_at'] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning freeze-user">冻结</button>
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

</div>
<script>
    var created_at = laydate.render({
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