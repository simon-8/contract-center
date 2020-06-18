@extends('layout.admin')

@section('content')

    <div class="ibox float-e-margins">
        <form method="post" class="form-horizontal" action="{{ isset($message->id) ? editURL('admin.message.update', $message->id) : route('admin.message.store') }}" id="sform">
            {!! csrf_field() !!}
            {!! method_field(isset($message->id) ? 'PUT' : 'POST') !!}
            <div class="col-sm-12 col-md-8">
                <div class="ibox-title">
                    @if(isset($message->id))
                        <h5>编辑站内信</h5>
                        <input type="hidden" name="id" value="{{ $message->id }}">
                    @else
                        <h5>添加站内信</h5>
                    @endif
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">接收人</label>
                        <div class="col-sm-11">
                            <input id="to_truename" type="text" class="form-control" value="{{ isset($message->to_userid) ? ($message->toUser->truename?:$message->toUser->nickname) : old('to_userid') }}" style="width: 200px;display: inline-block;">
                            <input id="to_userid" type="hidden" class="form-control" name="to_userid" value="{{ $message->to_userid ?? old('to_userid') }}">
                            <button type="button" class="btn btn-primary show-user" data-id="0"  data-href="{{ route('admin.user.index', ['callback' => 'selectSuccess']) }}">选择</button>
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">站内信标题</label>
                        <div class="col-sm-11">
                            <input id="title" type="text" class="form-control" name="title" value="{{ $message->title ?? old('title') }}">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label">内容</label>
                        <div class="col-sm-11">
                            {!! seditor($message->content ?? old('content')) !!}
                            <span class="help-block m-b-none">站内信内容</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
{{--                            {!! colorText($message->is_read, '已读', '未读') !!}--}}
                            {{--                            <input type="checkbox" name="status" value="1" id="status" class="switch" data-on-text="正常" data-off-text="关闭"/>--}}
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <a class="btn btn-white" href="javascript:history.go(-1);">返回</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <script>
        let layerIndex;
        let currentId;
        function selectSuccess(obj) {
            //if (parseInt(currentId)) {
            //
            //    document.getElementById('hotel_id_'+ currentId).value = obj.id;
            //    document.getElementById('hotel_name_'+ currentId).value = obj.name;
            //} else {
            //    document.getElementById('hotel_id').value = obj.id;
            //    document.getElementById('hotel_name').value = obj.name;
            //}
            $('#to_userid').val(obj.id);
            $('#to_truename').val(obj.truename || obj.nickname);
            layer.close(layerIndex);
        }
        $('.show-user').click(function() {
            let href = $(this).attr('data-href');
            let name = $(this).closest('tr').find('.name').text();
            currentId = $(this).attr('data-id');
            layerIndex = layer.open({
                area: ['95%', '95%'],
                shadeClose: true,
                type: 2,
                title: '酒店列表',
                content: href
            });
            return false;
        });
    </script>
@endsection
