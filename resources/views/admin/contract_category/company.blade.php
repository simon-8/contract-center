@extends('layout.admin')
@section('content')
    <div class="col-sm-12 col-md-12 col-lg-6 animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h5>合同分类</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-nowrap bg-white text-center">
                        <tr>
                            <td width="50">编号</td>
                            <td width="50">父分类ID</td>
                            <td width="150" align="left">分类名称</td>
                            <td>参与类型</td>
                            <td>我的身份</td>
                            <td>说明</td>
                            <td width="180">操作</td>
                        </tr>
                        @if($lists->count())
                            @foreach($lists as $v)
                                <tr>
                                    <td>{{ $v['id'] }}</td>
                                    <td>{{ $v['pid'] }}</td>
                                    <td align="left">{{ $v['name'] }}</td>
                                    <td>{{ $v['player_text'] }}</td>
                                    <td> - </td>
                                    <td>{{ $v['company_id'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="AddChild({{ $v['id'] }})">添加子分类</button>
                                        <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data='@json($v)' onclick="Edit({{ $v['id'] }}, '{{ editURL('admin.contract-category.update', $v['id']) }}')">编辑</button>
                                        <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.contract-category.destroy', $v['id']) }}')">删除</button>
                                    </td>
                                </tr>
                                @if(isset($v['child']) && count($v['child']))
                                    @foreach($v['child'] as $vv)
                                        <tr>
                                            <td>{{ $vv['id'] }}</td>
                                            <td>{{ $vv['pid'] }}</td>
                                            <td align="left" class="name">&nbsp;&nbsp;┗ {{ $vv['name'] }}</td>
                                            <td>{{ $vv['player_text'] }}</td>
                                            <td>{{ $vv['user_type_text'] }}</td>
                                            <td>{{ $vv['company_id'] }}</td>
                                            <td>
{{--                                                <button class="btn btn-xs btn-warning add-section" data-id="{{$v->id}}" data-players="{{$v->players}}">添加模块</button>--}}
                                                <button class="btn btn-sm btn-warning control-section" data-page="section" data-href="{{ route('admin.contract-tpl-section.index', ['catid' => $vv['id']]) }}">模块管理</button>
                                                <button class="btn btn-sm btn-info" id="edit_{{ $vv['id'] }}" data='@json($vv)' onclick="Edit({{ $vv['id'] }}, '{{ editURL('admin.contract-category.update', $vv['id']) }}')">编辑</button>
                                                <button class="btn btn-sm btn-danger" onclick="Delete('{{ editURL('admin.contract-category.destroy', $vv['id']) }}')">删除</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    未找到数据
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加分类</button>
            </div>
        </div>
        <script>
            var createModal = '#createModal';

            function AddChild(id) {
                var json = $('#edit_' + id).attr('data');
                json = JSON.parse(json);
                $(createModal).find('select[name=pid]').val(json.id);
                $(createModal).modal('show');
            }
            //$(function() {
            //    $("form [name='pid']").change(function() {
            //        let pid = $(this).val();
            //        let txt = $(this).find("option:selected").attr('data');
            //        $(this).closest('form').find("[name='name']").val(txt);
            //    });
            //});
        </script>
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
                let players = $(this).attr('data-players');
                $(createSectionModal).find('[name=catid]').val(catid);
                $(createSectionModal).find('[name=players]').val(players);
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
                        @if (!empty($data['company_id']))
                            <input type="hidden" name="company_id" value="{{ $data['company_id'] }}">
                        @endif
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">添加合同类型</h4>
                            {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                        </div>
                        <div class="modal-body">
                            @if (!empty($data['company_id']))
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">上级分类</label>
                                    <div class="col-sm-10">
                                        <select name="pid" class="form-control">
                                            <option value="0">请选择上级分类</option>
                                            @foreach(App\Models\ContractCategory::getParents($data['company_id']) as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block m-b-none">选择所属分类，不选择则代表一级分类</span>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-2 control-label">类型名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                           placeholder="房屋租赁">
                                    <span class="help-block m-b-none">用来显示的名称</span>
                                </div>
                            </div>
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
                                <label class="col-sm-2 control-label">我的身份</label>
                                <div class="col-sm-10">
                                    <select name="user_type" class="form-control">
                                        <option value="">选择合同默认身份</option>
                                        <option value="{{ App\Models\ContractCategory::USER_TYPE_FIRST }}">甲方</option>
                                        <option value="{{ App\Models\ContractCategory::USER_TYPE_SECOND }}">乙方</option>
                                        <option value="{{ App\Models\ContractCategory::USER_TYPE_THREE }}">居间人</option>
                                    </select>
                                    <span class="help-block m-b-none">选择后该类型合同将使用此身份</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">类型简介</label>
                                <div class="col-sm-10">
                                    <textarea name="introduce" class="form-control" rows="8" width="90%">{{ old('introduce') }}</textarea>
                                    <span class="help-block m-b-none">类型简介</span>
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
                        @if (!empty($data['company_id']))
                            <input type="hidden" name="company_id" value="{{ $data['company_id'] }}">
                        @endif
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">编辑</h4>
                            {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                        </div>
                        <div class="modal-body">
                            @if (!empty($data['company_id']))
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">上级分类</label>
                                    <div class="col-sm-10">
                                        <select name="pid" class="form-control">
                                            <option value="0">请选择上级分类</option>
                                            @foreach(App\Models\ContractCategory::getParents($data['company_id']) as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block m-b-none">选择所属分类，不选择则代表一级分类</span>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-2 control-label">类型名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="" placeholder="房屋租赁">
                                    <span class="help-block m-b-none">用来显示的名称</span>
                                </div>
                            </div>
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
                                <label class="col-sm-2 control-label">我的身份</label>
                                <div class="col-sm-10">
                                    <select name="user_type" class="form-control">
                                        <option value="">选择合同默认身份</option>
                                        <option value="{{ App\Models\ContractCategory::USER_TYPE_FIRST }}">甲方</option>
                                        <option value="{{ App\Models\ContractCategory::USER_TYPE_SECOND }}">乙方</option>
                                        <option value="{{ App\Models\ContractCategory::USER_TYPE_THREE }}">居间人</option>
                                    </select>
                                    <span class="help-block m-b-none">选择后该类型合同将使用此身份</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">类型简介</label>
                                <div class="col-sm-10">
                                    <textarea name="introduce" class="form-control" rows="8" width="90%">{{ old('introduce') }}</textarea>
                                    <span class="help-block m-b-none">类型简介</span>
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


        {{--createSection--}}
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
                            <input type="hidden" name="players" value="">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">模块名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                           placeholder="房屋基本情况">
                                    <span class="help-block m-b-none">合同中不同模块</span>
                                </div>
                            </div>
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

        {{--updateSection--}}
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
                            <input type="hidden" name="players" value="">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">模块名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                           placeholder="房屋基本情况">
                                    <span class="help-block m-b-none">合同中不同模块</span>
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
@endsection
