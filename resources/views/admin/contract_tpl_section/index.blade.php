{{--@inject('authService', 'App\Services\AuthService')--}}
@inject('contractModel', 'App\Models\Contract')
@inject('contractCategoryModel', 'App\Models\ContractCategory')

@extends('layout.admin')
@section('content')
    <div class="col-sm-12 col-lg-6 animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h5>模板块管理</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap bg-white text-center">
                        <tr>
                            <td width="50">排序</td>
                            <td width="50">编号</td>
                            <td width="150" align="left">模块名称</td>
                            <td>模板分类</td>
                            <td>参与人类型</td>
{{--                            <td>图标</td>--}}
                            <td width="180">操作</td>
                        </tr>
                        @if($lists->count())
                            @foreach($lists as $v)
                                <tr>
                                    <td>{{ $v['listorder'] }}</td>
                                    <td>{{ $v['id'] }}</td>
                                    <td align="left">{{ $v['name'] }}</td>
                                    <td>{{ $v->contractCategory->name }}</td>
                                    <td>{{ $contractModel->getPlayersText($v['catid']) }}</td>
{{--                                    <td></td>--}}
{{--                                    <td>--}}
                                        <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data='@json($v)' onclick="Edit1({{ $v['id'] }}, '{{ editURL('admin.contract-tpl-section.update', $v['id']) }}')">编辑</button>
                                        <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.contract-tpl-section.destroy', $v['id']) }}')">删除</button>
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
                </div>
                <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加模块</button>
            </div>
        </div>
        <script>

            function Edit1(id, url)
            {
                var updateModal = '#updateModal';
                var json = $('#edit_' + id).attr('data');
                json = JSON.parse(json);
                $.each(json , function(k , v){
                    if (k === 'catid') {
                        $(updateModal).find('[name=' + k + ']').val(v);
                    } else if (k === 'players') {
                        $(updateModal).find('[name=' + k + ']').val(v);
                    } else {
                        $(updateModal).find('[name=' + k + ']').val(v);
                    }

                });
                $(updateModal).find('form').attr('action', url);
                $(updateModal).modal('show');
            }
        </script>

        {{--delete--}}
        @include('admin.modal.delete')

        {{--create--}}
        <div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInDown">
                    <form action="{{ route('admin.contract-tpl-section.store') }}" method="POST" class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">添加模块</h4>
                            {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">模板分类</label>
                                <div class="col-sm-10">
                                    <select name="catid" class="form-control">
                                        @foreach($contractCategoryModel->getCats() as $catid => $catname)
                                            <option value="{{ $catid }}">{{ $catname }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block m-b-none">选择所属分类</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">参与人类型</label>
                                <div class="col-sm-10">
                                    <select name="players" class="form-control">
                                        @foreach($contractModel->getPlayers() as $typeid => $typename)
                                            <option value="{{ $typeid }}">{{ $typename }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block m-b-none">选择参与人类型</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">模块名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="房屋基本情况">
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
                <div class="modal-content animated bounceInDown">
                    <form action="" method="POST" class="form-horizontal">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <input type="hidden" name="id" value="">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">编辑菜单</h4>
                            {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">模板分类</label>
                                <div class="col-sm-10">
                                    <select name="catid" class="form-control">
                                        @foreach($contractCategoryModel->getCats() as $catid => $catname)
                                            <option value="{{ $catid }}">{{ $catname }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block m-b-none">选择所属分类</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">参与人类型</label>
                                <div class="col-sm-10">
                                    <select name="players" class="form-control">
                                        @foreach($contractModel->getPlayers() as $typeid => $typename)
                                            <option value="{{ $typeid }}">{{ $typename }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block m-b-none">选择参与人类型</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">模块名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="房屋基本情况">
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
    </div>
@endsection
