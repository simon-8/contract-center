@extends('layout.admin')
@section('content')
<div class="col-sm-12 col-lg-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>合同类型</h5>
        </div>
        <div class="ibox-content">
            <p>
                <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加</button>
            </p>
            @if($lists->count())
            @foreach($lists as $v)
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="table-responsive">
                    <table
                        class="table table-bordered table-striped table-hover text-nowrap bg-white text-center">
                        <tr>
                            <td width="50">编号</td>
                            <td>类型名称</td>
                            <td width="180">操作</td>
                        </tr>
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            <td class="name">
                                <span class="label label-default">{{ $v['name'] }}</span></td>
                            <td>
                                <button class="btn btn-xs btn-success add-section" data-id="{{$v->id}}">添加模块</button>
                                <button class="btn btn-xs btn-info" id="edit_{{ $v['id'] }}"
                                        data='@json($v)'
                                        onclick="Edit({{ $v['id'] }}, '{{ editURL('admin.contract-category.update', $v['id']) }}')">
                                    编辑
                                </button>
                                <button class="btn btn-xs btn-danger"
                                        onclick="Delete('{{ editURL('admin.contract-category.destroy', $v['id']) }}')">
                                    删除
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="no-padding">
                                <table
                                    class="table table-bordered table-striped table-hover text-nowrap bg-white text-center no-margins">
                                    <tr>
                                        <td width="50">参与人类型</td>
                                        <td>模块名称</td>
                                        <td width="180">操作</td>
                                    </tr>
                                    @foreach ($players as $typeid => $typename)
                                        @if(count($v->tplSection[$typeid]))
                                            @foreach ($v->tplSection[$typeid] as $k => $section)
                                                <tr>
                                                    @if($k === 0)
                                                        <td rowspan="{{count($v->tplSection[$typeid])}}">{{ $typename }}</td>
                                                    @endif
                                                    <td>{{ $section->name }}</td>
                                                    <td>
                                                        <button
                                                            data-href="{{ route('admin.contract-tpl.index', ['section_id' => $section->id, 'players' => $typeid]) }}"
                                                            class="btn btn-sm btn-secondary action-tpl">模板管理
                                                        </button>
                                                        <button class="btn btn-sm btn-info edit-section"
                                                                data-json='@json($section)'
                                                                data-href="{{ editURL('admin.contract-tpl-section.update', $section['id']) }}">
                                                            编辑
                                                        </button>
                                                        <button class="btn btn-sm btn-danger"
                                                                onclick="Delete('{{ editURL('admin.contract-tpl-section.destroy', $section['id']) }}')">
                                                            删除
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>{{ $typename }}</td>
                                                <td>空</td>
                                                <td></td>
                                            </tr>
                                        @endif
                                    @endforeach
{{--                                    <tr>--}}
{{--                                        <td colspan="3">--}}
{{--                                            <button class="btn btn-sm btn-success btn-block add-section" data-id="{{$v->id}}">添加模块</button>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endforeach
            @endif
            <div class="clearfix"></div>
        </div>
    </div>

    <script>
        let createSectionModal = '#createSectionModal';
        let updateSectionModal = '#updateSectionModal';
        $('.control-section').click(function () {
            let href = $(this).data('href'),
                page = $(this).data('page'),
                name = $(this).text();
            name = $(this).closest('tr').find('.name').text() + name;
            openFrame($(this), href, page, name);
        });

        $('.action-tpl').click(function () {
            layer.open({
                type: 2,
                title: '合同模板管理',
                content: $(this).data('href'),
                area: ['80%', '80%']
            });
        });
        $('.add-section').click(function () {
            let catid = $(this).attr('data-id');
            $(createSectionModal).find('[name=catid]').val(catid);
            $(createSectionModal).modal('show');
        });
        $('.edit-section').click(function() {
            let json = $(this).attr('data-json');
            let url = $(this).attr('data-href');
            json = JSON.parse(json);
            $.each(json, function (k, v) {
                $(updateSectionModal).find('[name=' + k + ']').val(v);
            });
            $(updateSectionModal).find('form').attr('action', url);
            $(updateSectionModal).modal('show');
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
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">添加</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类型名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                       placeholder="房屋租赁">
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
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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



{{--create--}}
<div class="modal inmodal" id="createSectionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInDown">
            <form action="{{ route('admin.contract-tpl-section.store') }}" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加模块</h4>
                    {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                </div>
                <div class="modal-body">
                    <input type="hidden" name="catid" value="">
                    {{--                    <div class="form-group">--}}
                    {{--                        <label class="col-sm-2 control-label">模板分类</label>--}}
                    {{--                        <div class="col-sm-10">--}}
                    {{--                            <select name="catid" class="form-control">--}}
                    {{--                                @foreach($contractCategoryModel->getCats() as $catid => $catname)--}}
                    {{--                                    <option value="{{ $catid }}">{{ $catname }}</option>--}}
                    {{--                                @endforeach--}}
                    {{--                            </select>--}}
                    {{--                            <span class="help-block m-b-none">选择所属分类</span>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">参与人</label>
                        <div class="col-sm-10">
                            <select name="players" class="form-control">
                                @foreach(App\Models\Contract::getPlayers() as $typeid => $typename)
                                    <option value="{{ $typeid }}">{{ $typename }}</option>
                                @endforeach
                            </select>
                            <span class="help-block m-b-none">选择参与人类型</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">模块名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                   placeholder="房屋基本情况">
                            <span class="help-block m-b-none">合同中不同模块</span>
                        </div>
                    </div>
                    {{--                        <div class="form-group">--}}
                    {{--                            <label class="col-sm-2 control-label">图标</label>--}}
                    {{--                            <div class="col-sm-10">--}}
                    {{--                                <input type="text" class="form-control" name="icon" value="{{ old('icon') }}" placeholder="fa-setting">--}}
                    {{--                                <span class="help-block m-b-none">图标</span>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="listorder"
                                   value="{{ old('listorder') ? old('listorder') : 0 }}" placeholder="0">
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
<div class="modal inmodal" id="updateSectionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInDown">
            <form action="" method="POST" class="form-horizontal">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                <input type="hidden" name="id" value="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">编辑模块</h4>
                    {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                </div>
                <div class="modal-body">
                    <input type="hidden" name="catid" value="">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">参与人</label>
                        <div class="col-sm-10">
                            <select name="players" class="form-control">
                                @foreach(App\Models\Contract::getPlayers() as $typeid => $typename)
                                    <option value="{{ $typeid }}">{{ $typename }}</option>
                                @endforeach
                            </select>
                            <span class="help-block m-b-none">选择参与人类型</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">模块名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                   placeholder="房屋基本情况">
                            <span class="help-block m-b-none">合同中不同模块</span>
                        </div>
                    </div>
                    {{--                        <div class="form-group">--}}
                    {{--                            <label class="col-sm-2 control-label">图标</label>--}}
                    {{--                            <div class="col-sm-10">--}}
                    {{--                                <input type="text" class="form-control" name="icon" value="" placeholder="fa-setting">--}}
                    {{--                                <span class="help-block m-b-none">图标</span>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
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
@endsection
