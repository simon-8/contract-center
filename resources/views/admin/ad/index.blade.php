@extends('layout.admin')
@section('content')
    <div class="mail-box-header">
        <h2>
            广告位管理 ({$total})
        </h2>
        <div class="mail-tools tooltip-demo m-t-md">
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="保存"
                    onclick="$('#sform').submit();"><i class="fa fa-check"></i> 保存
            </button>
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="刷新"
                    onclick="window.location.reload();"><i class="fa fa-refresh"></i> 刷新
            </button>
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="删除"
                    onclick="$('#sform').submit();"><i class="fa fa-trash-o"></i> 删除
            </button>

        </div>
    </div>
    <div class="mail-box">
        <table class="table table-bordered table-hover bg-white text-center">
            <tr>
                <td width="50">编号</td>
                <td width="150">名称</td>
                <td width="100">宽度</td>
                <td width="100">高度</td>
                <td width="180">操作</td>
            </tr>
            @if(isset($lists) && count($lists) > 0)
                @foreach($lists as $v)
                    <tr>
                        <td>{{ $v['id'] }}</td>
                        <td>{{ $v['name'] }}</td>
                        <td>{{ $v['width'] }}</td>
                        <td>{{ $v['height'] }}</td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="AddChild({{ $v['id'] }})">添加</button>
                            <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }})">编辑</button>
                            <button class="btn btn-sm btn-danger" onclick="Delete({{ $v['id'] }})">删除</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">
                        未找到数据
                    </td>
                </tr>
            @endif
        </table>
        @if(count($lists))
            <div class="text-center">
                {!! $lists->render() !!}
            </div>
        @endif
    </div>

    <script>

        var deleteModal = '#deleteModal';
        var updateModal = '#updateModal';
        var createModal = '#createModal';

        function Delete(id , name)
        {
            name = name ? name : 'id';
            $(deleteModal).find('input[name='+name+']').val(id);
            $(deleteModal).modal('show');
        }

        function Edit(id)
        {

            var json = $('#edit_' + id).attr('data');
            json = JSON.parse(json);
            $.each(json , function(k , v){
                $(updateModal).find('[name=' + k + ']').val(v);
            });

            $(updateModal).modal('show');
        }
        function AddChild(id) {
            var json = $('#edit_' + id).attr('data');
            //json = JSON.parse(json);
            //$(createModal).find('select[name=pid]').val(json.id);
            //$(createModal).find('input[name=prefix]').val(json.prefix);
            $(createModal).modal('show');
        }
    </script>

    {{--delete--}}
    @include('admin.modal.delete' , ['formurl' => route('admin.ad.delete')])

    {{--create--}}
    <div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <form action="{{ route('admin.ad.create') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">添加广告位</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="名称">
                                <span class="help-block m-b-none">用来区分管理</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">宽度</label>
                            <div class="col-sm-10">
                                <input id="prefix" type="text" class="form-control" name="width" value="{{ old('width') }}" placeholder="宽度">
                                <span class="help-block m-b-none">请填写整数</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">高度</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="height" value="{{ old('height') }}" placeholder="高度">
                                <span class="help-block m-b-none">请填写整数</span>
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

    {{--update--}}
    <div class="modal inmodal" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <form action="{{ route('admin.ad.update') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">编辑广告位</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="" placeholder="名称">
                                <span class="help-block m-b-none">用来区分管理</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">宽度</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="width" value="" placeholder="宽度">
                                <span class="help-block m-b-none">请填写整数</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">高度</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="height" value="" placeholder="高度">
                                <span class="help-block m-b-none">请填写整数</span>
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
@endsection('content')