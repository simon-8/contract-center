@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>分类管理</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-striped table-hover bg-white text-center">
                <tr>
                    <td width="30">排序</td>
                    <td width="50">编号</td>
                    <td width="50">上级分类</td>
                    <td width="150" align="left">名称</td>
                    <td width="100">子分类数量</td>
                    <td width="180">操作</td>
                </tr>
                @if(isset($lists) && count($lists) > 0)
                    @foreach($lists as $v)
                        <tr>
                            <td>{{ $v['listorder'] }}</td>
                            <td>{{ $v['id'] }}</td>
                            <td>{{ $pid ? $parent['name'] : '顶级分类' }}</td>
                            <td align="left">{{ $v['name'] }}</td>
                            <td>{{ $v->child()->count() }}</td>
                            <td>
                                <a href="{{ route('admin.category.index', ['pid' => $v['id']]) }}" class="btn btn-sm btn-success">子分类</a>
                                <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }})">编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="Delete({{ $v['id'] }})">删除</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">
                            未找到数据
                        </td>
                    </tr>
                @endif
            </table>
            <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加分类</button>
            @if ($pid)
                <a href="{{ route('admin.category.index', ['pid' => $parent['pid']]) }}" class="btn btn-warning">返回上级</a>
            @endif
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
                $(updateModal).find('[name=' + k + ']').val(v);
            });

            $(updateModal).modal('show');
        }
        function AddChild(id) {
            var json = $('#edit_' + id).attr('data');
            json = JSON.parse(json);
            $(createModal).find('select[name=pid]').val(json.id);
            $(createModal).modal('show');
        }
    </script>

    {{--delete--}}
    @include('admin.modal.delete' , ['formurl' => route('admin.category.delete')])

    {{--create--}}
    <div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <form action="{{ route('admin.category.create') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">添加分类</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">父分类</label>
                            <div class="col-sm-10">
                                @if ($pid)
                                    <input type="hidden" name="pid" value="{{ $pid }}">
                                    <input type="text" readonly class="form-control" value="{{ $pid }}">
                                @else
                                    <select name="pid" class="form-control">
                                        <option value="0">请选择</option>
                                        @if (isset($lists))
                                            @foreach($lists as $v)
                                                <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="help-block m-b-none">选择分类上级分类，不选择则代表一级分类</span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="名称">
                                <span class="help-block m-b-none">用来显示的名称</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="listorder" value="{{ old('listorder') ? old('listorder') : 0 }}" placeholder="0">
                                <span class="help-block m-b-none">越大越靠前</span>
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
                <form action="{{ route('admin.category.update') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">编辑分类</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">父分类</label>
                            <div class="col-sm-10">
                                @if ($pid)
                                    <input type="hidden" name="pid" value="{{ $pid }}">
                                    <input type="text" readonly class="form-control" value="{{ $pid }}">
                                @else
                                    <select name="pid" class="form-control">
                                        <option value="0">请选择</option>
                                        @if (isset($lists))
                                            @foreach($lists as $v)
                                                <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="help-block m-b-none">选择分类所属分类，不选择则代表一级分类</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="" placeholder="名称">
                                <span class="help-block m-b-none">用来显示的名称</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="listorder" value="" placeholder="0">
                                <span class="help-block m-b-none">越大越靠前</span>
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