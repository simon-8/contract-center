@extends('layout.admin')
@section('content')
<div class="col-sm-6 animated fadeInRight">

    <div class="ibox">
        <div class="ibox-title">
            <h5>广告管理 (当前广告位: {{ $adPlace['name'] }})</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-bordered table-hover bg-white text-center">
                <tr>
                    <th width="50">编号</th>
                    <th width="150">所属广告位</th>
                    <th width="150">标题</th>
                    <th width="100">简介</th>
                    <th width="100">图片</th>
                    <th width="80">链接</th>
                    <th width="180">操作</th>
                </tr>
                @if(isset($adPlace['ad']) && count($adPlace['ad']) > 0)
                    @foreach($adPlace['ad'] as $v)
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            <td>{{ $adPlace['name'] }}</td>
                            <td>{{ $v['title'] }}</td>
                            <td>{{ $v['content'] }}</td>
                            <td>
                                <a href="javascript:;" data-url="{{ $v['thumb'] }}" class="btn btn-warning btn-sm imgview">预览</a>
                            </td>
                            <td>
                                @empty($v['url'])
                                    无
                                @else
                                    <a href="{{ $v['url'] }}" target="_blank" class="btn btn-warning btn-sm">预览</a>
                                @endempty
                            </td>
                            <td>
                                <a href="" class="btn btn-info btn-sm">编辑</a>
                                <a href="" class="btn btn-danger btn-sm">删除</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            未找到数据
                        </td>
                    </tr>
                @endif
            </table>
            <button class="btn btn-success" data-toggle="modal" data-target="#createModal">添加广告</button>
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
            $(createModal).modal('show');
{{--            location.href = '{{ route('admin.ad.index') }}/items/' + id;--}}
        }
    </script>
    <script>
        $(function(){
            $('.imgview').click(function(){
                var src = $(this).attr('data-url');
                if( src ){
                    var w = {{ $adPlace['width'] }}+0;
                    var h = {{ $adPlace['height'] }}+42;
                    preview(src, w, h, "{{ $adPlace['name'] }}");
                }
            });
        })
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