@extends('layout.admin')
@section('content')
    <div class="col-sm-12 animated fadeInRight">

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover bg-white text-center text-nowrap">
                <thead>
                <tr class="text-center">
                    <th width="50">编号</th>
{{--                    <th width="150">用户名</th>--}}
                    <th>昵称</th>
                    <th>手机号码</th>
                    <th>国家</th>
                    <th>省份</th>
                    <th>城市</th>
                    <th>头像</th>
                    <th>性别</th>
                    {{--<th>关注时间</th>--}}
                    <th>个人认证</th>
                    <th>公司认证</th>
                    <th>冻结</th>
                    <th>注册时间</th>
{{--                    <th>更新时间</th>--}}
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $user['id'] }}</td>
{{--                    <td>{{ $user['username']?:'无' }}</td>--}}
                    <td>{{ $user['nickname'] }}</td>
                    <td>{{ $user['mobile']?:'无' }}</td>
                    <td>{{ $user['country'] }}</td>
                    <td>{{ $user['province'] }}</td>
                    <td>{{ $user['city'] }}</td>
                    <td><img src="{{ $user['avatar'] }}" alt="" width="30"></td>
                    <td>{!! $user['gender'] ? colorText($user['gender'] == 1, '男', '女') : '未知' !!}</td>
                    {{--<td>{{ $user['subscribe_at'] }}</td>--}}
                    <td>{!! colorText($user['is_block'], '是', '否') !!}</td>
                    <td>{!! colorText($user['vtruename'], '是', '否') !!}</td>
                    <td>{!! colorText($user['vcompany'], '是', '否') !!}</td>
                    <td>{{ $user['created_at'] }}</td>
{{--                    <td>{{ $user['updated_at'] }}</td>--}}
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
