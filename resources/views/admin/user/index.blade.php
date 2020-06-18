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
                        <th>冻结</th>
                        <th>注册时间</th>
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
                                <td>{{ $v['country'] }}</td>
                                <td>{{ $v['province'] }}</td>
                                <td>{{ $v['city'] }}</td>
                                <td><img src="{{ $v['avatar'] }}" alt="" width="30"></td>
                                <td>{!! $v['gender'] ? colorText($v['gender'] == 1, '男', '女') : '未知' !!}</td>
                                {{--<td>{{ $v['subscribe_at'] }}</td>--}}
                                <td>{!! colorText($v['is_block'], '是', '否') !!}</td>
                                <td>{{ $v['created_at'] }}</td>
                                <td>{{ $v['updated_at'] }}</td>
                                <td>
                                    @if(empty($data['callback']))
                                    <button class="btn btn-sm {{ $v->is_block ? 'btn-primary' : 'btn-danger' }} freeze-user" onclick="freeze('{{ route('admin.user.freeze', ['id' => $v->id]) }}')">
                                        {{ $v->is_block ? '解冻' : '冻结' }}
                                    </button>
                                    @else
                                        <a class="btn btn-xs btn-success choose-user" data-json='@json($v)'>选择</a>
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

    <div class="modal inmodal radius" id="freezeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">确认操作</h4>
                    <small class="font-bold text-danger">删除的数据无法恢复。</small>
                </div>
                {{--<div class="modal-body">--}}
                {{--<p>你开心就好。</p>--}}
                {{--</div>--}}
                <div class="modal-footer">
                    <form action="" method="POST" onsubmit="return freezeSubmit();">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-white radius" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary radius">确定</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    let freezeModal = '#freezeModal';
    function freeze(url, obj)
    {
        $(freezeModal).find('form').attr('action', url);
        $(freezeModal).modal('show');
        $(freezeModal).find('.text-danger').text($(obj).text());
    }
    function freezeSubmit()
    {
        let url = $(freezeModal).find('form').attr('action');
        loading();
        $.post(url, (res) => {
            loading(true);
            if (res.code) {
                layer.alert(res.message);
                return false;
            }
            $(freezeModal).modal('hide');
            layer.msg(res.message, (res) => {
                location.reload();
            })
        });
        return false;
    }

    @if(!empty($data['callback']))
    $('.choose-user').click(function () {
        let data = $(this).attr('data-json');
        parent.{{ $data['callback'] }}(JSON.parse(data));
        return false;
    });
    @endif
</script>
@endsection
