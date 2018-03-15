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
                            <td>&nbsp;&nbsp;┗ {{ $adPlace['name'] }}</td>
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
                                <button class="btn btn-sm btn-info" id="edit_{{ $v['id'] }}" data="{{ json_encode($v) }}" onclick="Edit({{ $v['id'] }})">编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="Delete({{ $v['id'] }})">删除</button>
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
                if (k === 'thumb') {
                    $(updateModal).find('[name=' + k + ']').val(v);
                    $(updateModal).find('#pthumb').iCheck('check');
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
    @include('admin.modal.delete' , ['formurl' => route('admin.ad.item.delete')])

    {{--create--}}
    <div class="modal inmodal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInX">
                <form action="{{ route('admin.ad.item.create') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <input type="hidden" name="pid" value="{{ $adPlace['id'] }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">添加广告</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="标题">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="content" value="{{ old('content') }}" placeholder="简介">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">图片</label>
                            <div class="col-sm-10">
                                <img src="{{ old('thumb') }}" id="pthumb" width="250" height="{{ calcHeight($adPlace['width'], 250, $adPlace['height']) }}">
                                <input type="hidden" id="thumb" name="thumb" value="{{ old('thumb') }}">
                                <button class="btn btn-sm" type="button" onclick="Sthumb('thumb', {{ $adPlace['width'] }}, {{ $adPlace['height'] }});" style="margin-top: 10px;">上传</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">外链</label>
                            <div class="col-sm-10">
                                <input type="url" class="form-control" name="url" value="{{ old('url') }}" placeholder="外链">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="listorder" value="{{ old('listorder') }}" placeholder="排序">
                                <span class="help-block m-b-none">数字越大, 排序越前</span>
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
                <form action="{{ route('admin.ad.item.update') }}" method="POST" class="form-horizontal">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="pid" value="{{ $adPlace['id'] }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">编辑广告</h4>
                        {{--<small class="font-bold text-danger">删了可就没有了我跟你讲，不要搞事情。</small>--}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="" placeholder="标题">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="content" value="" placeholder="简介">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">图片</label>
                            <div class="col-sm-10">
                                <img src="" id="pthumb" width="250">
                                <input type="hidden" id="thumb" name="thumb" value="">
                                <button class="btn btn-sm" type="button" onclick="Sthumb('thumb', {{ $adPlace['width'] }}, {{ $adPlace['height'] }});" style="margin-top: 10px;">上传</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">外链</label>
                            <div class="col-sm-10">
                                <input type="url" class="form-control" name="url" value="" placeholder="外链">
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="listorder" value="" placeholder="排序">
                                <span class="help-block m-b-none">数字越大, 排序越前</span>
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