@extends('layout.admin')
@section('content')
<div class="col-sm-8 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>广告位管理</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-hover bg-white text-center">
                <tr>
                    <th width="50">编号</th>
                    <th width="150">名称</th>
                    <th width="100">宽度</th>
                    <th width="100">高度</th>
                    <th width="80">状态</th>
                    <th width="180">操作</th>
                </tr>
                @if(isset($lists) && count($lists) > 0)
                    @foreach($lists as $v)
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            <td>{{ $v['name'] }}</td>
                            <td>{{ $v['width'] }}</td>
                            <td>{{ $v['height'] }}</td>
                            <td>{{ $v['status'] ? '正常' : '关闭' }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" onclick="AddChild({{ $v['id'] }})">添加广告</button>
                                <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }})">编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="Delete({{ $v['id'] }})">删除</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">
                            未找到数据
                        </td>
                    </tr>
                @endif
            </table>
            <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加广告位</button>
        </div>
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
                if (k === 'status') {
                    $(updateModal).find('[name=status][value='+v+']').iCheck('check');
                } else {
                    $(updateModal).find('[name=' + k + ']').val(v);
                }
            });

            $(updateModal).modal('show');
        }
        function AddChild(id) {
            //var json = $('#edit_' + id).attr('data');
            //json = JSON.parse(json);
            //$(createModal).find('select[name=pid]').val(json.id);
            //$(createModal).find('input[name=prefix]').val(json.prefix);
            //$(createModal).modal('show');
            location.href = '{{ route('admin.ad.index') }}/items/' + id;
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
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10">
                                <div class="i-checks radio">
                                    <label>
                                        <input type="radio" name="status" value="1" checked>开启
                                    </label>
                                    <label>
                                        <input type="radio" name="status" value="0">关闭
                                    </label>
                                </div>
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
                    <input type="hidden" name="aid" value="">
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
                        <div class="form-group">
                            <label class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10">
                                <div class="i-checks radio">
                                    <label>
                                        <input type="radio" name="status" value="1">开启
                                    </label>
                                    <label>
                                        <input type="radio" name="status" value="0">关闭
                                    </label>
                                </div>
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
</div>
@endsection('content')