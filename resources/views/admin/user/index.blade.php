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
                        <input type="text" name="created_at" id="created_at" class="form-control" autocomplete="off"  placeholder="点击选择" value="{{ $data['created_at']??'' }}">
                    </div>
                    <div class="input-group m-b">
                        <select name="identity" class="form-control inline">
                            <option value="" @if(!isset($data['identity']) || $data['identity'] === '') selected @endif>全部身份</option>
{{--                            <option value="is_seller"--}}
{{--                                    @if(isset($data['identity']) && $data['identity'] === 'is_normal') selected @endif--}}
{{--                            >@lang('user.alias.normal')</option>--}}
                            <option value="is_seller"
                                    @if(isset($data['identity']) && $data['identity'] === 'is_seller') selected @endif
                            >@lang('user.alias.seller')</option>
                            <option value="is_manager"
                                    @if(isset($data['identity']) && $data['identity'] === 'is_manager') selected @endif
                            >@lang('user.alias.manager')</option>
                        </select>
                    </div>
                    <div class="input-group1 m-b">
                        <select name="type" class="form-control inline">
                            <option value="nickname" @if (isset($data['type']) && $data['type'] === 'nickname') selected @endif>昵称</option>
                            <option value="mobile" @if (isset($data['type']) && $data['type'] === 'mobile') selected @endif>手机号</option>
                        </select>
                        <input type="text" name="keyword" id="keyword" class="form-control" autocomplete="off" style="width:180px;" placeholder="请输入关键词" value="{{ $data['keyword']??'' }}">
                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover bg-white text-center text-nowrap">
                    <thead>
                    <tr class="text-center">
                        <th width="50">编号</th>
                        {{--<th width="150">用户名</th>--}}
                        <th>身份</th>
                        <th>昵称</th>
                        <th>手机号码</th>
                        <th>活力值</th>
                        <th>元宝</th>
                        {{--<th>国家</th>--}}
                        {{--<th>省份</th>--}}
                        {{--<th>城市</th>--}}
                        <th>头像</th>
                        <th>性别</th>
                        {{--<th>关注时间</th>--}}
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th width="180">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($lists))
                        @foreach($lists as $v)
                            <tr>
                                <td>{{ $v['id'] }}</td>
                                <td>
                                @if($v->is_manager)
                                    <button class="btn btn-xs btn-primary btn-outline manager-relation" data-id='{{ $v->id }}'>@lang('user.alias.manager')</button>
                                @endif
                                @if($v->is_seller)
                                    <button class="btn btn-xs btn-success btn-outline seller-detail" data-json='@json($v)'>@lang('user.alias.seller')</button>
                                @endif
                                @if(!$v->is_manager && !$v->is_seller)
                                    <span class="btn btn-xs btn-warning btn-outline">@lang('user.alias.normal')</span>
                                @endif
                                </td>
                                {{--<td>{{ $v['username']?:'无' }}</td>--}}
                                <td>{{ $v['nickname'] }}</td>
                                <td>{{ $v['mobile']?:'无' }}</td>
                                <td>{{ $v['credit'] }}</td>
                                <td>{{ $v['coin'] }}</td>
                                {{--<td>{{ $v['city'] }}</td>--}}
                                {{--<td>{{ $v['province'] }}</td>--}}
                                {{--<td>{{ $v['country'] }}</td>--}}
                                <td><img src="{{ $v['avatar'] }}" alt="" width="30"></td>
                                <td>{{ $v['gender'] ? ($v['gender'] == 1 ? '男' : '女') : '未知' }}</td>
                                {{--<td>{{ $v['subscribe_at'] }}</td>--}}
                                <td>{{ $v['created_at'] }}</td>
                                <td>{{ $v['updated_at'] }}</td>
                                <td>
                                    @if(empty($data['callback']))
                                        @if($v->groupid)
                                            <button class="btn btn-sm btn-danger set-customer" data-href="{{ route('user.setCustomer', ['id' => $v['id'], 'cancel' => true]) }}" data-cancel="true">取消客服</button>
                                        @else
                                            <button class="btn btn-sm btn-primary set-customer" data-href="{{ route('user.setCustomer', ['id' => $v['id']]) }}">设置客服</button>
                                        @endif
                                        {{--<button class="btn btn-sm btn-warning freeze-user" data-href="{{ route('user.freeze', ['id' => $v['id']]) }}">冻结</button>--}}
                                    @else
                                        <button class="btn btn-sm btn-warning choose-user" data-json='@json($v)'>选择</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12">
                                未找到数据
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                @if(!empty($lists))
                    {!! $lists->render() !!}
                @endif
            </div>
            {{--<button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加用户</button>--}}
        </div>
    </div>

    {{--delete--}}
    @include('admin.modal.delete')

    <div class="modal inmodal radius" id="managerRelationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">查看</h4>
                    {{--<small class="font-bold text-danger">删除的数据无法恢复。</small>--}}
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover bg-white text-center text-nowrap">
                            <thead>
                                <tr>
                                    <th>关联ID</th>
                                    <th>关联名称</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="id"></td>
                                    <td class="name"></td>
                                    <td>
                                        <button class="btn btn-sm btn-danger remove-relation">解除关联</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--<div class="modal-footer">--}}
                    {{--{!! method_field('DELETE') !!}--}}
                    {{--<button type="button" class="btn btn-white radius" data-dismiss="modal">关闭</button>--}}
                    {{--<button type="submit" class="btn btn-primary radius">确定</button>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="setCustomerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <form action="" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">操作确认</h4>
                        <small class="font-bold text-danger"><span>修改</span>该用户客服权限。</small>
                    </div>
                    {{--<div class="modal-body">--}}
                    {{--</div>--}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">确定</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="freezeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <form action="" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">操作确认</h4>
                        <small class="font-bold text-danger"><span>修改</span>该用户客服权限。</small>
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
    let managerRelationModal = '#managerRelationModal';
    let setCustomerModal = '#setCustomerModal';
    let freezeModal = '#setCustomerModal';
    let searchForm = $('#searchForm');

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

    @if(!empty($data['callback']))
    $('.choose-user').click(function () {
        let json = $(this).attr('data-json');
        if (json) json = JSON.parse(json);
        parent.{{ $data['callback'] }}(json);
        return false;
    });
    @endif

    $('.manager-relation').click(function() {
        loading();
        let id = $(this).attr('data-id');
        $.get("{{ route('user.managerRelation') }}", {id: id}, function(res) {
            loading(true);
            if (res.code) {
                layer.alert(res.message);
                return;
            }
            for (key in res.data) {
                $(managerRelationModal).find('tbody tr .' + key).text(res.data[key]);
            }
            $(managerRelationModal).modal('show');
        });
        $(managerRelationModal + ' .remove-relation').unbind('click').click(function() {
            layer.confirm('确定解除关联吗？', {

            }, function(){
                $.post("{{ route('user.managerRelationRemove') }}", {id: id}, function(res) {
                    if (res.code) {
                        layer.alert(res.message);
                        return;
                    }
                    layer.alert(res.message, function(i) {
                        window.location.reload();
                        layer.close(i);
                    });
                });
            });
        });
    });

    $('.set-customer').click(function() {
        let action = $(this).attr('data-href');
        let cancel = $(this).attr('data-cancel') || false;
        $(setCustomerModal).find('form').attr('action', action);
        $(setCustomerModal).find('form .font-bold span').text(cancel ? '移除' : '设置');
        $(setCustomerModal).modal('show');
    });
    $('.set-customer').click(function() {
        let action = $(this).attr('data-href');
        let cancel = $(this).attr('data-cancel') || false;
        $(setCustomerModal).find('form').attr('action', action);
        $(setCustomerModal).find('form .font-bold span').text(cancel ? '移除' : '设置');
        $(setCustomerModal).modal('show');
    });
</script>
@endsection('content')