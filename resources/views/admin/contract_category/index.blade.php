@extends('layout.admin')
@section('content')
<div class="col-sm-12 col-lg-4 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>合同类型</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover text-nowrap bg-white text-center">
                <tr>
                    <td width="50">编号</td>
                    <td>类型名称</td>
                    <td width="180">操作</td>
                </tr>
                @if($lists->count())
                    @foreach($lists as $v)
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            <td class="name">{{ $v['name'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary control-section" data-page="section" data-href="{{ editURL('admin.contract-category.show', $v->id) }}">模块管理</button>
                                <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data='@json($v)' onclick="Edit({{ $v['id'] }}, '{{ editURL('admin.contract-category.update', $v['id']) }}')">编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.contract-category.destroy', $v['id']) }}')">删除</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">
                            未找到数据
                        </td>
                    </tr>
                @endif
            </table>
            </div>
            <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加</button>
        </div>
    </div>

    <script>
        $('.control-section').click(function() {
            let href = $(this).data('href'),
                page = $(this).data('page'),
                name = $(this).text();
            name = $(this).closest('tr').find('.name').text() + name;
            openFrame($(this), href, page, name);
        });
    </script>

    {{--delete--}}
    @include('admin.modal.delete')

    {{--create--}}
    <div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <form action="{{ route('admin.contract-category.store') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">添加</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类型名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="房屋租赁">
                                <span class="help-block m-b-none">用来显示的名称</span>
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
            <div class="modal-content animated bounceInDown">
                <form action="" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">编辑</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类型名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="" placeholder="房屋租赁">
                                <span class="help-block m-b-none">用来显示的名称</span>
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
@endsection
