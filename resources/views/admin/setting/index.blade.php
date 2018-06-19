@extends('layout.admin')

@section('content')
<div class="col-sm-12 col-md-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>基本设置</h5>
        </div>
        <div class="ibox-content clear">
            <form method="post" action="{{ editURL('setting.update', 1) }}" class="form-horizontal">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                @if(count($lists))
                    @foreach($lists as $k => $v)
                        <div class="form-group">
                            <div class="col-sm-1">
                                <label class="control-label">
                                    {{ $v['name'] }}
                                </label>
                            </div>

                            <div class="col-sm-11 input-group">
                                <input type="text" class="form-control" name="data[{{ $v['item'] }}][value]" value="{{ $v['value'] }}">
                                <div class="input-group-btn">
                                    <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">操作 <span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a onclick="Edit({{ $k }}, '{{ route('setting.store') }}')" id="edit_{{ $k }}" data="{{ json_encode($v) }}">编辑</a></li>
                                        <li><a onclick="Delete('{{ editURL('setting.destroy', $v['item']) }}')">删除</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    @endforeach
                @endif
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-2">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">添加选项</button>
                        <button class="btn btn-primary" type="submit">保存</button>
                        <button class="btn btn-warning" type="button" onclick="location.href=''">取消</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

{{--delete--}}
@include('admin.modal.delete')

{{--create--}}
<div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <form action="{{ route('setting.store') }}" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加设置</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选项名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="选项名">
                            <span class="help-block m-b-none">用来显示的名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">字段名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="item" value="{{ old('item') }}" placeholder="字段名">
                            <span class="help-block m-b-none">数据库中存储的字段名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选项值</label>
                        <div class="col-sm-10">
                            <input id="prefix" type="text" class="form-control" name="value" value="{{ old('value') }}" placeholder="选项值">
                            <span class="help-block m-b-none"></span>
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
            <form action="" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">修改设置</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选项名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="选项名">
                            <span class="help-block m-b-none">用来显示的名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">字段名</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" name="item" value="{{ old('item') }}" placeholder="字段名">
                            <span class="help-block m-b-none">数据库中存储的字段名称</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选项值</label>
                        <div class="col-sm-10">
                            <input id="prefix" type="text" class="form-control" name="value" value="{{ old('value') }}" placeholder="选项值">
                            <span class="help-block m-b-none"></span>
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
@endsection